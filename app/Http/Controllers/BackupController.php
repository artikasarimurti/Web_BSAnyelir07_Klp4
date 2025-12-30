<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        $backupDir = storage_path('app/backup');

        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        // Ambil semua file lalu jadikan Collection
        $backups = collect(File::files($backupDir))->map(function ($file) {
            return [
                'name' => $file->getFilename(),
                'size' => round($file->getSize() / 1024 / 1024, 2), // MB
                'created_at' => Carbon::createFromTimestamp($file->getCTime())
                                    ->format('d M Y, H:i'),
            ];
        })->sortByDesc('created_at')->values();

        return view('backup.index', compact('backups'));
    }

    // Jalankan Backup
    public function runBackup()
    {
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $backupDir = storage_path('app/backup');

        $filename = 'backup_' . now()->format('d_m_Y_H_i_s') . '.sql';
        $filePath = $backupDir . '/' . $filename;

        // Windows support: jika password kosong tidak pakai -p
        $passwordPart = $dbPass ? "-p$dbPass" : '';

        $command = "mysqldump -u $dbUser $passwordPart $dbName > \"$filePath\"";

        exec($command);

        return redirect()
            ->route('backup.index')
            ->with('success', "Backup berhasil dibuat: $filename");
    }

    public function downloadBackup($filename)
    {
        $filePath = storage_path("app/backup/$filename");
        
        if (!File::exists($filePath)) {
            return back()->with('error', 'File backup tidak ditemukan!');
        }

        return response()->download($filePath);
    }

    public function deleteBackup($filename)
    {
        $filePath = storage_path("app/backup/$filename");

        if (File::exists($filePath)) {
            File::delete($filePath);
            return back()->with('success', "Backup berhasil dihapus.");
        }

        return back()->with('error', 'File tidak ditemukan!');
    }
}
