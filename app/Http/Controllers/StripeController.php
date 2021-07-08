<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Coupon;

class StripeController extends Controller
{
    public function checkCouponCode(Request $request): \Illuminate\Http\JsonResponse
    {
        \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));

        try {
            $couponCode = Coupon::retrieve($request->discountCode);
            if ($couponCode['valid']) {
                $res['is_valid'] = true;
                $res['save_percentage'] = $couponCode['percent_off'];
                $res['amount_off'] = $couponCode['amount_off'] / 100;
            } else {
                $res['is_valid'] = false;
                $res['message'] = 'Discount Code is not Valid';
            }
        } catch (\Exception $exception) {
            $res['is_valid'] = false;
            $res['message'] = 'Discount Code is not Valid';
        }
        return response()->json($res);
    }

    public function createStripeSession(Request $request): \Illuminate\Http\JsonResponse
    {

        \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));

        $user = User::where('discord_id', $request->user)->first();

        if (empty($user)) {
            $res['success'] = false;
            $res['message'] = 'Invalid Access';
            return response()->json($res);
        }

        $couponCode = '';
        if (!empty($request->coupon_code)) {
            try {
                $couponCode = Coupon::retrieve($request->coupon_code);
                if ($couponCode['valid']) {
                    $couponCode = $request->coupon_code;
                } else {
                    $res['success'] = false;
                    $res['message'] = 'Discount Code is not Valid';
                    return response()->json($res);
                }
            } catch (\Exception $exception) {
                $res['success'] = false;
                $res['message'] = 'Discount Code is not Valid';
                return response()->json($res);
            }
        }


        try {

            $order = Order::create([
                'user_id' => $user->id,
                'product_id' => 'price_1J9tUwFwlPUjEiMMiW4OyWuU',
                'quantity' => $request->quantity,
                'status' => 0,
                'is_paid' => 0,
            ]);

            $session = Session::create([
                'success_url' => route('stripe.success') . '?stripe_id={CHECKOUT_SESSION_ID}&order=' . $order->id,
                'cancel_url' => url('/top-up'),
                'payment_method_types' => ['card'],
                'mode' => 'payment',
                'discounts' => [
                    [
                        "coupon" => $request->coupon_code
                    ]
                ],
                'line_items' => [[
                    'price' => $request->price_id,
                    'quantity' => 1,
                ]],
            ]);


            $res['success'] = true;
            $res['session_id'] = $session['id'];
            $res['public_key'] = config('app.stripe_public_key');
        } catch (\Exception $exception) {
            $res['success'] = false;
            $res['message'] = 'Server Error';
            return response()->json($res);
        }
        return response()->json($res);
    }

}
