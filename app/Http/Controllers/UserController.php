<?php

namespace App\Http\Controllers;

use App\Stock;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function createNewCapitalOneCustomer(Request $request) {
        $user = Auth::user();

        $user->street_number = $request->street_number;
        $user->street_name = $request->street_name;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;

        $coReq = new \stdClass();
        $names = explode(' ', $user->name);
        $coReq->first_name = $names[0];
        $coReq->last_name = $names[1];
        $coReq->address = new \stdClass();
        

        $client = new \GuzzleHttp\Client(['base_uri' => 'http://api.reimaginebanking.com/customers?key=d675ed2cf7224244143cd980b5bf1e46']);
        $r = $client->request('POST', 'http://api.reimaginebanking.com/customers?key=d675ed2cf7224244143cd980b5bf1e46', [
            'json' => [
                'first_name' => $names[0],
                'last_name' => $names[1],
                'address' => [
                    'street_number' => $user->street_number,
                    'street_name' => $user->street_name,
                    'city' => $user->city,
                    'state' => $user->state,
                    'zip' => $user->zip
                ]
            ]
        ]);
        $body = json_decode($r->getBody());
        $user->capitalOneID = $body->objectCreated->_id;
        $user->save();

        return redirect(route('home'));
    }

    function purchaseShares(Request $request) {
        $user = Auth::user();
        $location = new \stdClass();
        $location->lat = 41.4;
        $location->lon = -83.20;
        $stock = Stock::firstOrCreate(['name' => $request->symbol], ['name' => $request->symbol]);

        $url = 'http://api.reimaginebanking.com/accounts/' . $request->account . '?key=d675ed2cf7224244143cd980b5bf1e46';

        $client = new \GuzzleHttp\Client(['base_uri' => $url]);
        $r = $client->request('GET', $url);
        $body = json_decode($r->getBody());

        $totalPrice = round(floatval($request->price) * floatval($request->numShares), 2);

        if ($totalPrice > $body->balance) {
            flash()->error("Not enough money in account to make purchase!")->important();
        } else {
            $url = 'http://api.reimaginebanking.com/accounts/' . $request->account . '/withdrawals?key=d675ed2cf7224244143cd980b5bf1e46';

            $client = new \GuzzleHttp\Client(['base_uri' => $url]);
            $r = $client->request('POST', $url, [
                'json' => [
                    'medium' => "balance",
                    'transaction_date' => Carbon::now()->toDateString(),
                    'amount' => $totalPrice,
                    'description' => 'Purchase of ' . $stock->name . ' for $' . $totalPrice
                ]
            ]);

            $transaction = new Transaction();
            $transaction->price = $request->price;
            $transaction->amount = $request->numShares;
            $transaction->lat = $location->lat;
            $transaction->lng = $location->lon;
            $transaction->user_id = Auth::id();
            $transaction->stock_id = $stock->id;

            $transaction->save();

            flash()->success("Shares were purchased successfully!")->important();
        }

        return redirect(route('home'));
    }

    public function positions() {
        $positions = Auth::user()->transactions()->with('stock')->get();

        $positions->transform(function ($item, $key) {
            $symbol = $item->stock->name;
            $url = "https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=" . $symbol . "&interval=1min&apikey=3IF3IW1LBN2W7OGI";

            $client = new \GuzzleHttp\Client(['base_uri' => $url]);
            $r = $client->request('GET', $url);
            $body = json_decode($r->getBody());
            $key = $body->{"Meta Data"}->{"3. Last Refreshed"};
            $item->curPrice = $body->{'Time Series (1min)'}->{$key}->{'4. close'};
            $item->yield = (($item->curPrice * $item->amount) - ($item->price * $item->amount)) / ($item->price * $item->amount);
            return $item;
        });

        return response()->json($positions);
    }
}
