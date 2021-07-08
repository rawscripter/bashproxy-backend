<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function customers(Request $request): \Illuminate\Http\JsonResponse
    {
        $auth = User::where('email', $request->email)->where('role', 'admin')->first();
        if (!empty($auth)) {
            $user = User::query();
            $user->where('role', 'customer');
            if ($request->searchData != '') {
                $user->where('email', 'LIKE', "%" . $request->searchData . "%");
                $user->orWhere('name', 'LIKE', "%" . $request->searchData . "%");
                $user->orWhere('discord_id', 'LIKE', "%" . $request->searchData . "%");
            }
            $customers = $user->get();

            $res['customers'] = CustomerResource::collection($customers);

            return response()->json($res);
        } else {
            return response()->json([
                'Invalid Access'
            ]);

        }
    }

    public function orders(Request $request): \Illuminate\Http\JsonResponse
    {
        $auth = User::where('email', $request->email)->where('role', 'admin')->first();
        if (!empty($auth)) {
            $order = Order::query();
            $order->where('status', '=', 1);
            $order->where('is_paid', '=', 1);
            if ($request->searchData != '') {
                $searchQuery = $request->searchData;
                $order->whereHas('user', function ($order) use ($searchQuery) {
                    $order->where('email', 'LIKE', "%" . $searchQuery . "%");
                    $order->orWhere('name', 'LIKE', "%" . $searchQuery . "%");
                    $order->orWhere('discord_id', 'LIKE', "%" . $searchQuery . "%");
                });
                $order->orWhere('discount_code', 'LIKE', "%" . $searchQuery . "%");
            }
            $orders = $order->get();

            $res['orders'] = OrderResource::collection($orders);

            return response()->json($res);
        } else {
            return response()->json([
                'Invalid Access'
            ]);

        }
    }

    public function dashboardSummery(Request $request): \Illuminate\Http\JsonResponse
    {
        $auth = User::where('email', $request->email)->where('role', 'admin')->first();
        if (!empty($auth)) {

            $res['total_customers'] = User::where('role', 'customer')->get()->count();
            $res['recent_orders'] = Order::where('is_paid', 1)
                ->where('status', 1)
                ->where('created_at', '>', Carbon::now()->subDays(30))
                ->get()->count();
            $res['recent_sales'] = Order::where('is_paid', 1)->where('status', 1)->sum('paid_amount');
            $res['recent_sales'] = number_format(floatval($res['recent_sales'] / 100), 2, '.', '');
            return response()->json($res);
        } else {
            return response()->json([
                'Invalid Access'
            ]);

        }
    }
}
