<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;

class Currency extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'currency'
    ];

    public function cards()
    {
        $this->hasMany(Account::class);
    }
}