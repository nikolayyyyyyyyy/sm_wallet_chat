<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function getCurrencies()
    {
        $currencies = Currency::all();

        return response()->json($currencies, 200);
    }

    public function storeCurrency(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'currency' => 'required|unique:currencies,currency'
        ],[
            'currency.required' => 'Полето е задължително.',
            'currency.unique' => 'Има запис с тази валута.'
        ]);

        if($validate->fails()){
            return response()->json([
                'errors' => $validate->errors()
            ], 422);
        }

        Currency::create([
            'currency' => $request->input('currency')
        ]);

        return response()->json("aaa");
    }
}
