<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{

        public function allNotifications(){
        $admin = User::find(auth()->id());
        return response()->json(['notifications'=>$admin->notifications]);
    }


    function markReadAll()
    {
        $admin = User::find(auth()->id());
        foreach ($admin->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return response()->json([
            "message" => "success"
        ]);
    }

    public function unread(){
        $admin = User::find(auth()->id());
        return response()->json([
            "notifications" => $admin->unreadNotifications
        ]);
    }


    public function deleteAll(){
        $admin = User::find(auth()->id());
        $admin->notifications()->delete();
        return response()->json([
            "message" => "deleted"
        ]);
    }

    function delete($id)
    {
        DB::table('notifications')->where('id', $id)->delete();
        return response()->json([
            "message" => "deleted"
        ]);
    }




}
