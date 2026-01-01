<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Currency;
use App\Models\AccountType;
class Account extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'account_number',
        'amount',
        'interest',
        'currency_id',
        'account_type_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function account_type()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }
}