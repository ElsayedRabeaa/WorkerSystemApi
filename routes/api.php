<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{AdminController,WorkerController,ClientController,
PostController,AdminDashboardController,ChangeStatusPostController};
use App\Models\Worker;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

     Route::get('date',function(){
        // $Worker=Worker::first();
        $date=date_create("2013-03-15");
        return date_format(  $date,"2023-07-18T00:00:00.000000Z");

    //    $date=\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$Worker->created_at)->format('Y-m-d');
        //  return $Worker->created_at;
     });


    Route::controller(AdminController::class)->prefix("admin")->group(function(){

    Route::post("/register", "register");
    Route::post("/login", "login")->name('login');
    Route::get("/profile", "profile");
    Route::post("/logout", "logout");

    });



    Route::controller(WorkerController::class)->prefix("worker")->group(function(){

    Route::post("/register", "register");
    Route::post("/login", "login");
    Route::get("/profile", "profile");
    Route::post("/logout", "logout");
    });




    Route::controller(ClientController::class)->prefix("client")->group(function(){

    Route::post("/register", "register");
    Route::post("/login", "login");
    Route::get("/profile", "profile");
    Route::post("/logout", "logout");

    });



    Route::controller(PostController::class)->prefix("worker")->group(function(){
    Route::post("/add_post", "store")->middleware('auth:worker');

    });


    Route::controller(AdminDashboardController::class)->middleware('auth:admin')->prefix("admin")->group(function(){

    Route::get("/all", "allNotifications");
    Route::get("/unread", "unread");
    Route::post('/markReadAll', 'markReadAll');
    Route::delete("/deleteAll", "deleteAll");
    Route::delete('/delete/{id}', 'delete');
    });


    Route::controller(PostController::class)->prefix("posts")->group(function(){
       
        Route::get("/approved", "approvedPosts");
       
    });


    Route::controller(ChangeStatusPostController::class)->middleware('auth:admin')->prefix("posts")->group(function(){
       
        Route::post("/changeStatus", "changeStatus");
       
    });
?>