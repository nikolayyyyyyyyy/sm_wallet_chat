<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\AccountType;
use App\Models\TransactionType;
use App\Models\Account;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'role_name' => 'Админ'
        ]);
        Role::create([
            'role_name' => 'Потребител'
        ]);

        Currency::create([
            'currency' => 'BGN'
        ]);
        Currency::create([
            'currency' => 'EUR'
        ]);
        Currency::create([
            'currency' => 'USD'
        ]);

        AccountType::create([
            'account_type' => 'Разплащателна',
        ]);
        AccountType::create([
            'account_type' => 'Спестовна'
        ]);
        AccountType::create([
            'account_type' => 'Кредитна'
        ]);

        TransactionType::create([
            'transaction_type' => 'Превод'
        ]);
        TransactionType::create([
            'transaction_type' => 'Депозит'
        ]);

        User::create([
            'username' => 'Nikolayyy',
            'email' => 'niki@niki',
            'password' => '11111',
            'profile_photo' => null,
            'role_id' => 1 
        ]);
        User::create([
            'username' => 'Naskooo',
            'email' => 'nasi@nasi',
            'password' => '11111',
            'profile_photo' => null,
            'role_id' => 2 
        ]);

        Account::create([
            'account_number' => 'BGN45DFR44',
            'amount' => 20000,
            'interest' => 0.1,
            'currency_id' => 1,
            'account_type_id' => 1,
            'user_id' => 1
        ]);
        Account::create([
            'account_number' => 'BGN77HDF56',
            'amount' => 10000,
            'interest' => 0.1,
            'currency_id' => 1,
            'account_type_id' => 2,
            'user_id' => 2
        ]);
    }
}
