<?php

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\Route;
use App\Models\Post;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's
    Route::get("users",[APIController::class,'users']);
    Route::post('newpost', [APIController::class, 'newpost']);
    Route::post('modifypost', [APIController::class, 'modifypost']);
    Route::post('newcomment', [APIController::class, 'newcomment']);
    Route::post('modifycomment', [APIController::class, 'modifycomment']);
    Route::post('deletecomment', [APIController::class, 'deletecomment']);
    Route::get("users",[APIController::class,'users']);

});

Route::get('posts', [APIController::class, 'posts']);
Route::get("post/{id}",[APIController::class,'getpost']);
Route::post("login",[APIController::class,'index']);
