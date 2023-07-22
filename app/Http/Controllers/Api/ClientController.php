<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    // Client REGISTER API - POST
    public function register(Request $request)
    {
        // validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:clients",
            "password" => "required"
        ]);
// create Client data + save
        $Client = new Client();
        $Client->name = $request->name;
        $Client->email = $request->email;
        $Client->password = bcrypt($request->password);
        $Client->save();
// send response
        return response()->json([
            "status" => 1,
            "message" => "Client registered successfully"
        ], 200);
    }
// Client LOGIN API - POST
       public function login(Request $request)
       {
        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
// verify Client + token
        if (!$token = auth()->guard('client')->attempt(["email" => $request->email, "password" => $request->password])) {
        return response()->json([
                "status" => 0,
                "message" => "Invalid credentials"
            ]);
        }
// send response
        return response()->json([
            "status" => 1,
            "message" => "Logged in successfully",
            "access_token" => $token
        ]);
    }
// Client PROFILE API - GET
    public function profile()
    {
        $client_data =auth()->guard('client')->user();
     return response()->json([
            "status" => 1,
            "message" => "Client profile data",
            "data" => $client_data
        ]);
    }
// Client LOGOUT API - GET
    public function logout()
    {
        auth()->guard('client')->logout();
       return response()->json([
            "status" => 1,
            "message" => "Client logged out"
        ]);
    }
}