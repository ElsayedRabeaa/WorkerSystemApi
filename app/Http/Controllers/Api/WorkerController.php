<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class WorkerController extends Controller
{
    // Worker REGISTER API - POST
    public function register(Request $request)
    {
        // validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:workers",
            "password" => "required"
        ]);
// create Worker data + save
        $Worker = new Worker();
        $Worker->name = $request->name;
        $Worker->email = $request->email;
        $Worker->password = bcrypt($request->password);
       /*  $Worker->created_at =Carbon::createFromFormat('m/d/Y', now())->format('Y-m-d'); */
        $Worker->save();
// send response
        return response()->json([
            "status" => 1,
            "message" => "Worker registered successfully"
        ], 200);
    }
// Worker LOGIN API - POST
       public function login(Request $request)
       {
        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
// verify Worker + token
        if (!$token = auth()->guard('worker')->attempt(["email" => $request->email, "password" => $request->password])) {
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
// Worker PROFILE API - GET
    public function profile()
    {
        $Worker_data = auth()->guard('worker')->user();
     return response()->json([
            "status" => 1,
            "message" => "Worker profile data",
            "data" => $Worker_data
        ]);
    }
// Worker LOGOUT API - GET
    public function logout()
    {
        auth()->guard('worker')->logout();
       return response()->json([
            "status" => 1,
            "message" => "Worker logged out"
        ]);
    }
}