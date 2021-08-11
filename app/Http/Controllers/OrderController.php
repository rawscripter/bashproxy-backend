<?php

namespace App\Http\Controllers;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Stripe\Coupon;
use Stripe\Checkout\Session;

class OrderController extends Controller
{
    public function testOrder()
    {
        // $stripe = \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));

        // $sripe = new \Stripe\StripeClient(config('app.stripe_secret_key'));

        // $testCoupon =   $sripe->coupons->delete(
        //     'SbXm9B7o',
        //     []
        // );


        // $testCoupon = Coupon::create([
        //     'amount_off' => 949,
        //     'currency' => 'usd',
        //     'duration' => 'forever',
        // ]);

        // dd($testCoupon);
        // $user =  User::find(1);

        // $orders =   Order::where('user_id', 1)->get();

        // foreach ($orders as $order) {
        //     $order->delete();
        // }

        // $user->delete();


        // Coupon::create()

        // return  Order::where('is_paid', 1)->get();
        // $headers = [
        //     'Authorization' => config('app.bash_proxy_token'),
        // ];
        // $client = new Client([
        //     'headers' => $headers
        // ]);


        // $user = User::find(8);

        // // create new user if not exists
        // $this->createNewUser($client, $user);

        // $requestUrl = config('app.bash_proxy_base_url') . '/user/quota?userID=469033947834089483&quota=1';
        // $r = $client->request('PUT', $requestUrl);
        // $statusCode = $r->getStatusCode();
        // if ($statusCode == 200) {
        //     die('ok');
        // } else {
        //     die('not ok');
        // }
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

                $r = $this->createNewUser($client, $order->user);

                if ($order->is_quota_added != 1) {

                    // $requestUrl = config('app.bash_proxy_base_url') . '/user?userID=' . $order->user->discord_id;
                    // $r = $client->request('POST', $requestUrl);

                    // create new user if not exists

                    $requestUrl = config('app.bash_proxy_base_url') . '/user/quota?userID=' . $order->user->discord_id . '&quota=' . $order->quantity;
                    $r = $client->request('PUT', $requestUrl);
                    $statusCode = $r->getStatusCode();
                    if ($statusCode == 200) {
                        $order->is_quota_added = 1;
                        $order->save();
                    }
                }
                // dd($r);
                // dd($order);
                return redirect('/');
            }
        } catch (\Exception $exception) {
            return redirect('/top-up');
            // dd($exception);
        }
    }

    public function createNewUser($client, $user): bool
    {
        try {

            $requestUrl = config('app.bash_proxy_base_url') . '/user?userID=' . $user->discord_id;
            $r = $client->request('POST', $requestUrl);

            $statusCode = $r->getStatusCode();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
