<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SettingController;
use App\Http\Livewire\Pagesettings;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/main', [App\Http\Controllers\PublicController::class, 'main'])->name('main');
Route::get('/main/{id}', [App\Http\Controllers\PublicController::class, 'main_post'])->name('main_post');

Route::resource('posts', PostController::class);
Route::resource('categories', CategoryController::class);
Route::resource('tags', TagController::class);
Route::resource('roles', RoleController::class);
Route::resource('comments', CommentController::class);

Route::get('/settings', Pagesettings::class)->name('settings');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
