<?php
/**
 * Database Export Script for Hostinger Deployment
 * Run this locally to export your database
 */

// Database configuration (from your .env)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'posnex';

// Export filename
$filename = 'database_dump_' . date('Y-m-d_H-i-s') . '.sql';

echo "Exporting database '$database' to '$filename'...\n";

// Command to export database
$command = sprintf(
    'mysqldump --user=%s --password=%s --host=%s %s > %s',
    escapeshellarg($username),
    escapeshellarg($password),
    escapeshellarg($host),
    escapeshellarg($database),
    escapeshellarg($filename)
);

// Execute the command
$output = [];
$returnCode = 0;
exec($command, $output, $returnCode);

if ($returnCode === 0) {
    echo "✅ Database exported successfully to: $filename\n";
    echo "📁 File size: " . number_format(filesize($filename) / 1024, 2) . " KB\n";
    echo "\n📤 Ready to upload to Hostinger!\n";
    echo "1. Upload this file to your Hostinger hosting\n";
    echo "2. Import it via phpMyAdmin in Hostinger cPanel\n";
} else {
    echo "❌ Error exporting database. Return code: $returnCode\n";
    echo "Output: " . implode("\n", $output) . "\n";
    
    echo "\n🔧 Alternative method:\n";
    echo "1. Open phpMyAdmin locally\n";
    echo "2. Select your database\n";
    echo "3. Click 'Export' → 'Go'\n";
    echo "4. Save the .sql file\n";
} 