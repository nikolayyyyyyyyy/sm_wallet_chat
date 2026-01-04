<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Account;

class TransactionController extends Controller
{
    public function getTransactionsForAccount(string $id)
    {
        $transactions = Transaction::where('account_sender_id', '=', $id)
            ->orWhere('account_receiver_id', '=', $id)
            ->orderBy('id', 'desc')
            ->get();

            $transactions->load([
                'sender_account',
                'receiver_account',
                'transaction_type',
                'receiver_account.currency',
                'receiver_account.account_type',
                'sender_account.currency',
                'sender_account.account_type',
                'receiver_account.user',
                'sender_account.user',
            ]);
        return response()->json($transactions);
    }

    public function storeTransaction(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'amount' => 'required|numeric',
                'note' => 'nullable|string|max:255',
                'transaction_type_id' => 'required|integer|exists:transaction_types,id',
                'account_sender_number' => 'nullable|exists:accounts,account_number',
                'account_sender_id' => 'nullable|exists:accounts,id',
                'account_receiver_number' => 'required|exists:accounts,account_number',
            ],
            [
                'amount.required' => 'Полето е задължително.',
                'amount.numeric' => 'Сумата трябва да бъде число.',
                'note.max' => 'Бележката не може да надвишава 255 символа.',
                'transaction_type_id.required' => 'Полето е задължително.',
                'account_sender_number.required' => 'Полето е задължително.',
                'account_sender_number.exists' => 'Номера на изпращача не съществува.',
                'account_receiver_number.required' => 'Полето е задължително.',
                'account_receiver_number.exists' => 'Номера на получател не съществува.'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request->input("account_sender_id")){
            $account_sender = Account::where("id", "=", $request->account_sender_id)->first();
        } else {
            $account_sender = Account::where("account_number", "=", $request->account_sender_number)->first();
        }

        $account_receiver = Account::where("account_number", "=", $request->account_receiver_number)->first();
        if($account_sender->id == $account_receiver->id){
            return response()->json(['same_account' => 'Не може да правиш транзакция от една сметка в самата нея.'], 422);
        }

        if ($account_sender->amount < $request->amount) {
            return response()->json(["not_enought_money" => "Надвишаване на наличността."], 422);
        }

        $account_sender->amount -= $request->amount;
        $account_receiver->amount += $request->amount;
        $account_sender->save();
        $account_receiver->save();

        Transaction::create([
            'amount' => $request->amount,
            'note' => $request->note,
            'transaction_type_id' => $request->transaction_type_id,
            'account_sender_id' => $account_sender->id,
            'account_receiver_id' => $account_receiver->id,
        ]);

        return response()->json(status: 201);
    }
}
