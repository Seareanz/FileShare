<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class ShareController extends Controller
{
    /**
     * Resolve a shareable file by token, returning an error payload when unavailable.
     *
     * @return File|array{title: string, message: string}
     */
    private function resolveFile(string $token): File|array
    {
        $file = File::where('token', $token)->first();

        if (! $file) {
            return [
                'title' => 'Invalid link',
                'message' => 'This share link is not valid. Please double-check the URL.',
            ];
        }

        if ($file->isExpired()) {
            return [
                'title' => 'Link expired',
                'message' => 'This file link has expired.',
            ];
        }

        if (! Storage::disk('local')->exists($file->path)) {
            return [
                'title' => 'File unavailable',
                'message' => 'This file is no longer available for download.',
            ];
        }

        return $file;
    }

    public function show(string $token)
    {
        $file = $this->resolveFile($token);

        if (is_array($file)) {
            return view('share.error', $file);
        }

        return view('share.show', compact('file'));
    }

    public function download(string $token)
    {
        $file = $this->resolveFile($token);

        if (is_array($file)) {
            return view('share.error', $file);
        }

        // Increment download counter only when the download actually starts.
        $file->increment('download_count');

        return Storage::disk('local')->download($file->path, $file->original_name);
    }
}
