<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'details',
        'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
