<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use App\Models\User;
use Exception;


class AuthController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $client = new Client();

        try {
            return $client->post(config('service.passport.login_endpoint'), [
                "form_params" => [
                    "client_secret" => config('service.passport.client_secret'),
                    "grant_type" => "password",
                    "client_id" => config('service.passport.client_id'),
                    "username" => $request->email,
                    "password" => $request->password
                ]
            ]);
        }
        catch (BadResponseException $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function register(Request $request){
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|min:6',
        ]);
        try{
            $user = new User();
            $user->email = $request->email;
            $user->name = $request->name;
            $user->password = app('hash')->make($request->password);
            $user->save();
            return response(
                [
                    'status' => 'success',
                    'message' => 'User Created'
                ]
            );
        }
        catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

    }

    public function logout(Request $request){
        try{
            auth()->user()->tokens()->each(function ($token) {
                $token->delete();
            });
            return response()->json(['status' => 'error', 'message' => 'Logout Complete']);
        }
        catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
