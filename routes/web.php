<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Livewire\Pagesettings;
use App\Http\Controllers\SendEmailController;


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

Route::get('/', [PublicController::class, 'main'])->name('main');
Route::get('/category/{id}', [PublicController::class, 'category'])->name('category');
Route::get('/main', [PublicController::class, 'main'])->name('main');
Route::get('/{id}', [PublicController::class, 'singlePost'])->name('singlePost');
Route::get('/download-file/{id}', [PublicController::class, 'fileDownload'])->name('fileDownload');

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::resource('posts', PostController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('comments', CommentController::class);

    Route::get('/settings', Pagesettings::class)->name('settings');
    Route::get('/send-email', [SendEmailController::class, 'index']);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

