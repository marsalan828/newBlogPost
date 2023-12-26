<?php

use App\Http\Controllers\commentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// POST
Route::middleware('auth','admin')->group(function(){
    Route::post('post-approve',[PostController::class,'approvePost']);
});

Route::get('show-approved',[PostController::class,'showApproved']);
Route::get('show-unapproved',[PostController::class,'showUnapproved']);

Route::post('create-post',[PostController::class,'createPost']);
Route::put('update-post',[PostController::class,'updatePost']);

Route::delete('delete-post',[PostController::class,'deletePost']);  

// COMMENT

Route::post('create-comment',[commentController::class,'createComment']);


// USER

Route::post('create-user',[PostController::class,'RegisterUser']);
Route::get('show-admin',[PostController::class,'showAdmin']);
Route::get('show-user',[PostController::class,'showUsers']);
Route::put('update-user',[PostController::class,'UpdateUser']);
Route::delete('delete-user',[PostController::class,'destroyUser']);



