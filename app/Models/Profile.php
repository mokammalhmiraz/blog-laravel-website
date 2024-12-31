<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'image', 'name', 'mail', 'address', 'info'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
