<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\ChangeStatusPostRequest;

class ChangeStatusPostController extends Controller
{
    public function changeStatus(ChangeStatusPostRequest $request){
     $post=Post::find($request->post_id);
     $post->update([
        'status'=>$request->status,
        'rejected_reason'=>$request->rejected_reason,
     ]);

     Notification::send($post->worker, new AdminPost( $post,$post->worker));
     return response()->json(['Updated Successfully',200]);
    }
}
