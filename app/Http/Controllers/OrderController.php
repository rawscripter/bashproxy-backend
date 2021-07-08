<?php

namespace App\Http\Controllers;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;

class OrderController extends Controller
{
    public function testOrder()
    {
        $headers = [
            'Authorization' => config('app.bash_proxy_token'),
        ];
        $client = new Client([
            'headers' => $headers
        ]);

        $requestUrl = config('app.bash_proxy_base_url') . '/user/quota?userID=531646189603389472&quota=1';
        $r = $client->request('PUT', $requestUrl);
        $statusCode = $r->getStatusCode();
        if ($statusCode == 200) {
            die('ok');
        } else {
            die('not ok');
        }
    }

    public function createNewOrderOnPaymentSuccess(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));
        try {
            $session = Session::retrieve($request->stripe_id);
            $order = Order::find($request->order);
            if ($session['payment_status'] === 'paid') {
                $order->update([
                    'customer_id' => $session['customer'],
                    'customer_email' => $session['customer_details']['email'],
                    'discount_amount' => $session['total_details']['amount_discount'],
                    'currency' => $session['currency'],
                    'product_price' => $session['amount_subtotal'],
                    'paid_amount' => $session['amount_total'],
                    'status' => 1,
                    'is_paid' => 1,
                ]);
                $headers = [
                    'Authorization' => config('app.bash_proxy_token'),
                ];
                $client = new Client([
                    'headers' => $headers
                ]);


                if ($order->is_quota_added != 1) {
                    $requestUrl = config('app.bash_proxy_base_url') . '/user/quota?userID=' . $order->user->discord_id . '&quota=' . $order->quantity;
                    $r = $client->request('PUT', $requestUrl);
                    $statusCode = $r->getStatusCode();
                    if ($statusCode == 200) {
                        $order->is_quota_added = 1;
                        $order->save();
                    }
                }

                return redirect('/');
            }
        } catch (\Exception $exception) {
            return redirect('/top-up');

        }
    }
}
