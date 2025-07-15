<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'type',
        'cell_no',
        'email',
        'ntn',
        'tel_no',
        'taxCash',
        'taxCard',
        'taxOnline',
        'website',
        'address',
        'logo',
    ];
}
