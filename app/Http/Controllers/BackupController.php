<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function runBackup(Request $request)
    {
        $exitCode = Artisan::call('backup:run');
        if ($exitCode === 0) {
            return back()->with('success', 'Backup completed successfully!');
        } else {
            return back()->with('error', 'Backup failed. Please check the logs.');
        }
    }

    public function runRestore(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            abort(403);
        }
        $file = $request->input('file');
        if (!$file) {
            return back()->with('error', 'No backup file specified.');
        }
        $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
        $filePath = 'Laravel/' . $file;
        if (!$disk->exists($filePath)) {
            return back()->with('error', 'Backup file not found.');
        }
        // Extract the backup zip to a temp directory
        $tmpDir = storage_path('app/restore_tmp');
        if (!is_dir($tmpDir)) mkdir($tmpDir, 0777, true);
        $zip = new \ZipArchive;
        $res = $zip->open($disk->path($filePath));
        if ($res === TRUE) {
            $zip->extractTo($tmpDir);
            $zip->close();
        } else {
            return back()->with('error', 'Failed to extract backup zip.');
        }
        // Find the database dump file (usually *.sql)
        $sqlFile = collect(scandir($tmpDir))->first(function($f) use ($tmpDir) {
            return is_file($tmpDir . DIRECTORY_SEPARATOR . $f) && str_ends_with($f, '.sql');
        });
        if (!$sqlFile) {
            return back()->with('error', 'No SQL file found in backup.');
        }
        $sqlPath = $tmpDir . DIRECTORY_SEPARATOR . $sqlFile;
        // Restore the database (WARNING: this will overwrite all data)
        $db = config('database.connections.mysql.database');
        $user = config('database.connections.mysql.username');
        $pass = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port', 3306);
        $cmd = sprintf('mysql -h%s -P%s -u%s %s < "%s"%s', $host, $port, $user, $db, $sqlPath, $pass ? " -p$pass" : '');
        $output = null;
        $result = null;
        exec($cmd, $output, $result);
        // Clean up
        foreach (scandir($tmpDir) as $f) {
            if ($f !== '.' && $f !== '..') @unlink($tmpDir . DIRECTORY_SEPARATOR . $f);
        }
        @rmdir($tmpDir);
        if ($result === 0) {
            return back()->with('success', 'Database restored successfully!');
        } else {
            return back()->with('error', 'Restore failed. Please check the SQL file and database credentials.');
        }
    }

    public function listBackups()
    {
        $user = auth()->user();
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            abort(403);
        }
        $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
        $files = $disk->files('Laravel'); // Default backup folder is storage/app/Laravel
        $backups = collect($files)->filter(function($file) {
            return str_ends_with($file, '.zip');
        })->sortDesc();
        return view('admin.backups', compact('backups'));
    }

    public function downloadBackup($file)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            abort(403);
        }
        $disk = Storage::disk(config('backup.backup.destination.disks')[0] ?? 'local');
        $filePath = 'Laravel/' . $file;
        if (!$disk->exists($filePath)) {
            abort(404);
        }
        return $disk->download($filePath);
    }
} 