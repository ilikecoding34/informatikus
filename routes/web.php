<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Livewire\Tags as TagsLivewire;
use App\Livewire\Categories as CategoriesLivewire;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Livewire\Pagesettings;
use App\Livewire\Profile as ProfileLivewire;
use App\Livewire\CommentsTable as CommentsTableLivewire;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;

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
Route::get('/by-category/{id}', [PublicController::class, 'byCategory'])->name('by-category');
Route::get('/main', [PublicController::class, 'main'])->name('main');
Route::get('/post/{id}', [PublicController::class, 'singlePost'])->name('singlePost');
Route::get('/download-file/{id}', [PublicController::class, 'fileDownload'])->name('fileDownload');

Auth::routes(['verify' => true]);

// Admin login and registration (dedicated pages; no auth links in main header)
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminRegisterController::class, 'register']);
// Send default auth URLs to admin pages
Route::redirect('/login', '/admin/login')->name('login');
Route::redirect('/register', '/admin/register')->name('register');

Route::middleware(['verified'])->group(function () {
    Route::post('posts/{post}/deactivate', [PostController::class, 'deactivate'])->name('posts.deactivate');
    Route::post('posts/{post}/activate', [PostController::class, 'activate'])->name('posts.activate');
    Route::resource('posts', PostController::class);
    Route::get('/categories', CategoriesLivewire::class)->name('categories.index');
    Route::get('/tags', TagsLivewire::class)->name('tags.index');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/comments', CommentsTableLivewire::class)->name('comments.index');
    Route::get('/comments/create', [CommentController::class, 'create'])->name('comments.create');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::match(['put', 'patch'], '/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/profile', ProfileLivewire::class)->name('profile');
    Route::redirect('/settings', '/profile')->name('settings');
    Route::get('/send-email', [SendEmailController::class, 'index']);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

