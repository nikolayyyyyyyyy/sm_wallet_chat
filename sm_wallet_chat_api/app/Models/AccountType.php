<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Account;

class AccountType extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'account_type'
    ];

    public function cards()
    {
        $this->hasMany(Account::class);
    }
}