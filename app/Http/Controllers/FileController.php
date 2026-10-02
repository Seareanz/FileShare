<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Models\File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = File::where('user_id', $user->id);

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('original_name', 'like', '%'.$search.'%');
        }

        // Filter by extension
        if ($request->filled('extension')) {
            $extension = $request->input('extension');
            $query->where('original_name', 'like', '%.'.$extension);
        }

        // Sort
        $sort = $request->input('sort', 'newest');
        match ($sort) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            'name' => $query->orderBy('original_name', 'asc'),
            'size' => $query->orderBy('size', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $files = $query->paginate(15)->withQueryString();

        // Get unique extensions for filter dropdown
        $extensions = File::where('user_id', $user->id)
            ->select('original_name')
            ->get()
            ->map(fn ($file) => pathinfo($file->original_name, PATHINFO_EXTENSION))
            ->unique()
            ->values();

        return view('files.index', compact('files', 'extensions'));
    }

    public function create()
    {
        return view('files.create');
    }

    public function store(UploadFileRequest $request)
    {
        $validated = $request->validated();
        $uploadedFile = $request->file('file');
        $user = Auth::user();

        // Generate safe random filename
        $extension = strtolower($uploadedFile->extension());
        $storedName = Str::random(40).'.'.$extension;

        // Store file in private storage
        $path = $uploadedFile->storeAs(
            'files/'.$user->id,
            $storedName,
            'local'
        );

        // Calculate expiration
        $expiration = $validated['expiration'];
        $expiresAt = match ($expiration) {
            '1day' => now()->addDay(),
            '7days' => now()->addDays(7),
            '30days' => now()->addDays(30),
            default => null,
        };

        // Create database record
        $file = File::create([
            'user_id' => $user->id,
            'original_name' => $uploadedFile->getClientOriginalName(),
            'stored_name' => $storedName,
            'path' => $path,
            'mime_type' => $uploadedFile->getMimeType(),
            'size' => $uploadedFile->getSize(),
            'token' => Str::random(32),
            'download_count' => 0,
            'expires_at' => $expiresAt,
        ]);

        return redirect()->route('dashboard')->with('success', 'File uploaded successfully!');
    }

    public function show(File $file)
    {
        $this->authorize('view', $file);

        return view('files.show', compact('file'));
    }

    public function download(File $file)
    {
        $this->authorize('download', $file);

        if ($file->isExpired()) {
            return redirect()->back()->with('error', 'This file link has expired.');
        }

        if (! Storage::disk('local')->exists($file->path)) {
            return redirect()->back()->with('error', 'File not found on storage.');
        }

        // Increment download counter
        $file->increment('download_count');

        return Storage::disk('local')->download($file->path, $file->original_name);
    }

    public function destroy(File $file)
    {
        $this->authorize('delete', $file);

        // Delete physical file
        if (Storage::disk('local')->exists($file->path)) {
            Storage::disk('local')->delete($file->path);
        }

        // Delete database record
        $file->delete();

        return redirect()->route('dashboard')->with('success', 'File deleted successfully.');
    }
}
