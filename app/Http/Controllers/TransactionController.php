<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Transaction::with('user', 'stock')->whereBetween("lat", [floatval($request->lat) - 1, floatval($request->lat) + 1])
            ->whereBetween("lng", [floatval($request->lng) - 1, floatval($request->lng) + 1])->orderByDesc('created_at')->take(10)
            ->get()->map(function ($item, $key) {
                $newValue = new \stdClass();
                $newValue->position = new \stdClass();
                $newValue->position->lat = $item->lat;
                $newValue->position->lng = $item->lng;
                $newValue->infoText = $item->user->name . " bought " . $item->stock->name . " for $" . round($item->price * $item->amount, 2);
                return $newValue;
            });

        return response()->json($transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function latest()
    {
        $transactions = Transaction::with('user', 'stock')->orderByDesc('created_at')->take(10)
            ->get()->map(function ($item, $key) {
                $newValue = new \stdClass();
                $newValue->position = new \stdClass();
                $newValue->position->lat = $item->lat;
                $newValue->position->lng = $item->lng;
                $newValue->infoText = $item->user->name . " bought " . $item->stock->name;
                $newValue->amount = $item->amount;
                return $newValue;
            });

        return response()->json($transactions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
