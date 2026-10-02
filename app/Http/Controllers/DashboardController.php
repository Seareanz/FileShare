<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $files = File::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalFiles = $files->count();
        $totalStorage = $files->sum('size');
        $totalDownloads = $files->sum('download_count');

        return view('dashboard', compact('files', 'totalFiles', 'totalStorage', 'totalDownloads'));
    }
}
