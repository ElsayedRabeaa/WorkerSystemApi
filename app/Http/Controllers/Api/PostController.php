<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\AdminPost;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
 
    public function index()
    {
        $posts=Post::all();
        return response()->json(["posts"=>$posts,200]);
    }




    public function approvedPosts()
    {
        $approvedPosts=Post::where('status','approved')->get()->makeHidden('status');
        return response()->json(["approvedPosts"=>$approvedPosts,200]);
    }


    public function store(PostRequest $request)
    {
   try { 


       if($request->has('image'))
       {                                                                                                                                                                                                                                                                                                                                                                                                                                               
        $imageName=time().".".$request->image->extension();
        $request->image->move('posts',$imageName);
       }

       $post=Post::create([
        'worker_id'=>auth()->guard('worker')->user()->id,
        'content'=>$request->content,
        'price'=>$request->price,
        'image'=>$imageName,
        'status'=>'pending',
        'rejected_reason'=>'processing',
       ]);

       // Notification
       $admins=User::get();
       Notification::send($admins, new AdminPost( $post ,auth()->guard('worker')->user()->id ));

       return response()->json(['Created Successfully',200]);
        }
       catch (\Throwable $th) {
        return response()->json([$th,'failed',404]);

        } 

    }



    public function update(Request $request, int $id)
    {
        $post=Post::findorfail($id);
        $updatedPost=$post->update([$request->all()]);
        if($updatedPost){
            return response()->json(['Updated Successfully',200]);
        }else{
            return response()->json([$th,'failed',404]);
        }
    }

  
    public function destroy(int $id)
    {
        $post=Post::findorfail($id);
        $deleteedPost=$post->destroy([$request->all()]);
        if($deleteedPost){
            return response()->json(['Deleteed Successfully',200]);
        }else{
            return response()->json([$th,'failed',404]);
        }
    }
}
