<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TransactionType;
use App\Models\Account;

class Transaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'amount',
        'note',
        'transaction_type_id',
        'account_sender_id',
        'account_receiver_id'
    ];

    public function transaction_type()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function sender_account()
    {
        return $this->belongsTo(Account::class, 'account_sender_id');
    }

    public function receiver_account()
    {
        return $this->belongsTo(Account::class, 'account_receiver_id');
    }
}