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


        }

        $headers = [
            'Authorization' => config('app.bash_proxy_token'),
        ];
        $client = new Client([
            'headers' => $headers
        ]);

        $this->createNewUser($client, $user);

        if ($user->id) {
            $response = '';
            return response()->json(['app' => 'Login Successful', 'bash' => $response, 'role' => $user->role]);
        } else {
            return response()->json('Login failed');
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
