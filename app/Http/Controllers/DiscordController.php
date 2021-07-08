<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DiscordController extends Controller
{
    public function createOrRegisterUser(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = User::where('email', $request->email)->orWhere('discord_id', $request->id)->first();
        if (empty($user)) {
            $user = User::create([
                'email' => $request->email,
                'discord_id' => $request->id,
                'name' => $request->username,
                'role' => 'customer',
            ]);
            //create new user at basproxy

            try {
                $headers = [
                    'Authorization' => config('app.bash_proxy_token'),
                ];
                $client = new Client([
                    'headers' => $headers
                ]);
                $requestUrl = config('app.bash_proxy_base_url') . '/user?userID=' . $request->id;
                $r = $client->request('POST', $requestUrl);
                $response = $r->getBody()->getContents();
            } catch (\Exception $exception) {
                $response = 'User Already Exists';
            }

        }
        if ($user->id) {
            $response = '';
            return response()->json(['app' => 'Login Successful', 'bash' => $response, 'role' => $user->role]);
        } else {
            return response()->json('Login failed');
        }
    }
}
