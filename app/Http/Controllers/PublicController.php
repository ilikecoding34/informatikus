<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Comment;

class PublicController extends Controller
{
    public function main(){
        $posts = Post::with('user')->get();
        return view('main', compact('posts'));
    }

    public function main_post($id){
        $settings = Setting::find(1);
        $post = Post::where('id', $id)->with(['user','comments', 'tags'])->first();
        return view('main2', compact('post', 'settings'));
    }
}
