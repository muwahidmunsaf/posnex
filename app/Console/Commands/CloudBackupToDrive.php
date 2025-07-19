<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CloudBackup;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CloudBackupToDrive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloud:backup-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uploads a full system backup to Google Drive for each admin with a connected account, according to their schedule.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking cloud backup schedules...');
        \Log::info('CloudBackupToDrive: handle() called');
        $now = Carbon::now();
        $cloudBackups = CloudBackup::where('provider', 'google')->get();
        
        if ($cloudBackups->isEmpty()) {
            $this->info('No cloud backup schedules found.');
            return;
        }
        
        $this->info("Found {$cloudBackups->count()} cloud backup schedule(s).");
        
        foreach ($cloudBackups as $cloudBackup) {
            if (!$cloudBackup->refresh_token) {
                $this->warn("Skipping {$cloudBackup->email} - no refresh token configured.");
                \Log::info('CloudBackupToDrive: skipping user without refresh token', ['email' => $cloudBackup->email]);
                continue;
            }
            
            // Check if backup is due (remove the forced $due = true)
            $last = $cloudBackup->last_run_at ? Carbon::parse($cloudBackup->last_run_at) : null;
            $targetTime = Carbon::parse($now->format('Y-m-d') . ' ' . $cloudBackup->time);
            
            // Add debug logging for schedule logic
            \Log::info('CloudBackupToDrive: schedule check', [
                'user_id' => $cloudBackup->user_id,
                'email' => $cloudBackup->email,
                'now' => $now->toDateTimeString(),
                'last_run_at' => $last ? $last->toDateTimeString() : null,
                'targetTime' => $targetTime->toDateTimeString(),
                'frequency' => $cloudBackup->frequency,
            ]);
            
            $due = false;
            if ($cloudBackup->frequency === 'daily') {
                $due = (!$last || $last->lt($targetTime)) && $now->gte($targetTime);
            } elseif ($cloudBackup->frequency === 'weekly') {
                $due = (!$last || $last->lt($targetTime->copy()->subWeek())) && $now->gte($targetTime) && $now->isSameDay($targetTime);
            } elseif ($cloudBackup->frequency === 'monthly') {
                $due = (!$last || $last->lt($targetTime->copy()->subMonth())) && $now->gte($targetTime) && $now->day === $targetTime->day;
            }
            
            \Log::info('CloudBackupToDrive: due result', [
                'user_id' => $cloudBackup->user_id,
                'due' => $due,
            ]);
            
            if (!$due) {
                $nextRun = $last ? $last->addDay() : $targetTime;
                $this->info("Backup not due for {$cloudBackup->email} ({$cloudBackup->frequency} at {$cloudBackup->time}). Next check: {$nextRun->format('Y-m-d H:i')}");
                \Log::info('CloudBackupToDrive: backup not due, skipping', ['email' => $cloudBackup->email]);
                continue;
            }
            
            $this->info("Starting backup for {$cloudBackup->email}...");
            
            // Generate backup ZIP
            $backupDir = storage_path('full_backup_' . uniqid());
            mkdir($backupDir);
            
            try {
                $this->info("Creating database backup...");
                $db = config('database.connections.mysql');
                $dbFile = $backupDir . '/database_backup.sql';
                $cmd = sprintf(
                    'mysqldump --user=%s --password=%s --host=%s %s > %s',
                    escapeshellarg($db['username']),
                    escapeshellarg($db['password']),
                    escapeshellarg($db['host']),
                    escapeshellarg($db['database']),
                    escapeshellarg($dbFile)
                );
                @exec($cmd);
                
                $this->info("Copying application files...");
                $storageSource = storage_path('app');
                $storageDest = $backupDir . '/files';
                $this->recurseCopy($storageSource, $storageDest);
                
                $this->info("Creating ZIP archive...");
                $zipPath = storage_path('app/full_backup_' . date('Ymd_His') . '_' . $cloudBackup->user_id . '.zip');
                $zip = new \ZipArchive();
                $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
                
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($backupDir));
                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relPath = substr($filePath, strlen($backupDir) + 1);
                        $zip->addFile($filePath, $relPath);
                    }
                }
                $zip->close();
                
                // Clean up temp directory
                $this->recurseDelete($backupDir);
                
                $this->info("Uploading to Google Drive...");
                // Upload to Google Drive using user's refresh token
                $client = new \Google_Client();
                $client->setClientId(config('filesystems.disks.google.clientId'));
                $client->setClientSecret(config('filesystems.disks.google.clientSecret'));
                $client->setAccessType('offline');
                $client->setPrompt('consent');
                $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
                $client->refreshToken($cloudBackup->refresh_token);
                
                $service = new \Google_Service_Drive($client);
                $fileMetadata = new \Google_Service_Drive_DriveFile([
                    'name' => basename($zipPath),
                    'parents' => $cloudBackup->folder_id ? [$cloudBackup->folder_id] : null,
                ]);
                
                $content = file_get_contents($zipPath);
                $service->files->create($fileMetadata, [
                    'data' => $content,
                    'mimeType' => 'application/zip',
                    'uploadType' => 'multipart',
                ]);
                
                // Update last run time
                $cloudBackup->last_run_at = $now;
                $cloudBackup->save();
                
                // Clean up ZIP file after successful upload
                @unlink($zipPath);
                
                $this->info("✅ Backup uploaded to Google Drive for user {$cloudBackup->email}");
                \Log::info('CloudBackupToDrive: backup completed successfully', ['email' => $cloudBackup->email]);
                
            } catch (\Exception $e) {
                // Clean up on error
                if (isset($backupDir) && file_exists($backupDir)) {
                    $this->recurseDelete($backupDir);
                }
                if (isset($zipPath) && file_exists($zipPath)) {
                    @unlink($zipPath);
                }
                
                $this->error("❌ Failed to upload backup for user {$cloudBackup->email}: " . $e->getMessage());
                \Log::error('CloudBackupToDrive: backup failed', [
                    'email' => $cloudBackup->email,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        $this->info('Cloud backup check completed.');
    }

    // Copy logic from AdminBackupController
    private function recurseCopy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                $srcPath = $src . '/' . $file;
                $dstPath = $dst . '/' . $file;
                
                // Skip backup files and directories to prevent snowball effect
                if (is_dir($srcPath) && (
                    strpos($file, 'full_backup_') === 0 ||
                    strpos($file, 'backup_') === 0 ||
                    $file === 'backups'
                )) {
                    continue;
                }
                
                // Skip backup ZIP files
                if (is_file($srcPath) && (
                    strpos($file, 'full_backup_') === 0 ||
                    strpos($file, 'backup_') === 0 ||
                    strpos($file, '.zip') !== false
                )) {
                    continue;
                }
                
                if (is_dir($srcPath)) {
                    $this->recurseCopy($srcPath, $dstPath);
                } else {
                    copy($srcPath, $dstPath);
                }
            }
        }
        closedir($dir);
    }
    
    private function recurseDelete($dir)
    {
        if (!file_exists($dir)) return;
        foreach (scandir($dir) as $file) {
            if ($file == '.' || $file == '..') continue;
            $full = $dir . '/' . $file;
            if (is_dir($full)) $this->recurseDelete($full);
            else @unlink($full);
        }
        @rmdir($dir);
    }
}
