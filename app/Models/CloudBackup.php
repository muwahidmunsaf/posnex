<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CloudBackup extends Model
{
    protected $fillable = [
        'user_id',
        'provider',
        'email',
        'name',
        'refresh_token',
        'folder_id',
        'frequency',
        'time',
        'last_run_at',
    ];

    protected $casts = [
        'last_run_at' => 'datetime',
    ];
}
