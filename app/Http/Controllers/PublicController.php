<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Setting;

class PublicController extends Controller
{
    public function main(){
        $settings = Setting::find(1);
        $posts = Post::with('user')->get();
        return view('main2', compact('posts', 'settings'));
    }

    public function main_post($id){
        $post = Post::with(['user:id,name','comments.user:id,name'])->find($id);
        return view('main_post', compact('post'));
    }
}
