<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    public function updateCurrency(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'currency' => 'required|max:20|unique:currencies,currency,' . $id
        ],[
            'currency.required' => 'Полето е задължително.',
            'currency.unique' => 'Има запис с тази валута.',
            'currency.max' => 'Полето трябва да е до 20 символа.'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $currency = Currency::where('id', '=', $id)->first();
        if($currency == null)
        {
            return response()->json([
                'error_message' => 'No currency with this id foind.'
            ]);
        }

        $currency->currency = $request->currency;
        $currency->save();

        return response()->json(status: 200);
    }

    public function getCurrency(string $id)
    {
        $currency = Currency::where('id', '=', $id)->first();
        if($currency == null)
        {
            return response()->json([
                'error' => 'No currency with this id found.'
            ]);
        }

        return response()->json($currency, 200);
    }

    public function deleteCurrency(string $id)
    {
        $currency = Currency::where('id', '=', $id)->first();
        if($currency == null)
        {
            return response()->json([
                'error_message' => 'No currency found.'
            ]);
        }

        $currency->delete();
        return response()->json(status: 200);
    }

    public function getCurrencies()
    {
        $currencies = Currency::orderBy('id', 'desc')->get();
        if($currencies == null)
        {
            return response()->json([
                'error_message' => 'No currencies found.'
            ]);
        }

        return response()->json($currencies, 200);
    }

    public function storeCurrency(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'currency' => 'required|max:20|unique:currencies,currency'
        ],[
            'currency.required' => 'Полето е задължително.',
            'currency.unique' => 'Има запис с тази валута.',
            'currency.max' => 'Полето трябва да е до 20 символа.'
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
