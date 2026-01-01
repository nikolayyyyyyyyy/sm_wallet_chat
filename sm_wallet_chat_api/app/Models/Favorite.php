<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'liked_user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function liked_user()
    {
        return $this->belongsTo(User::class, 'liked_user_id');
    }
}