<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class InactivateDueUsers extends Command
{
    protected $signature = 'users:inactivate-due';
    protected $description = 'Set users as inactive whose inactive_at date has passed';

    public function handle()
    {
        $now = Carbon::now();

        $users = User::where('status', true)
            ->whereNotNull('inactive_at')
            ->where('inactive_at', '<=', $now)
            ->get();

        foreach ($users as $user) {
            $user->status = false;
            $user->save();
            $this->info("User {$user->name} set to inactive.");
        }

        $this->info("✅ All due users marked as inactive.");
    }
}
