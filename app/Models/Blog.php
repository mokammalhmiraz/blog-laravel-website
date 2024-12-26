<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // Add the 'thumbnail' field to the fillable property
    protected $fillable = [
        'title',
        'content',
        'category',
        'status',
        'added_by',
        'created_at',
        'thumbnail', // Add this line
    ];
}
