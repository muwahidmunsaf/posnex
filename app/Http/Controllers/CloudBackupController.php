<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\CloudBackup;

class CloudBackupController extends Controller
{
    // Show settings page
    public function settings()
    {
        $cloudBackup = CloudBackup::where('user_id', Auth::id())->where('provider', 'google')->first();
        return view('admin.cloud_backup_settings', compact('cloudBackup'));
    }

    // Start Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(config('services.google.scope'))
            ->with(['access_type' => 'offline', 'prompt' => 'consent'])
            ->redirect();
    }

    // Handle Google OAuth callback
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        // Save or update credentials
        CloudBackup::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'provider' => 'google',
            ],
            [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'refresh_token' => $googleUser->refreshToken,
                'folder_id' => null, // Optionally set via UI later
            ]
        );
        return redirect()->route('cloud-backup.settings')->with('success', 'Google Drive connected successfully!');
    }

    // POST /manage-backup/cloud-settings (cloud-backup.settings.update)
    public function updateSettings(Request $request)
    {
        $request->validate([
            'frequency' => 'required|in:daily,weekly,monthly',
            'time' => 'required|date_format:H:i',
        ]);
        $cloudBackup = CloudBackup::where('user_id', Auth::id())->where('provider', 'google')->first();
        if (!$cloudBackup) {
            return redirect()->route('cloud-backup.settings')->with('error', 'No Google Drive account connected.');
        }
        $cloudBackup->update([
            'frequency' => $request->frequency,
            'time' => $request->time,
        ]);
        return redirect()->route('cloud-backup.settings')->with('success', 'Backup schedule updated successfully.');
    }
}
