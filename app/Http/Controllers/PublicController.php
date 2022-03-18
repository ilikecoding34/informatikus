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
        $comments = Comment::where('post_id', 1)->get();
        $post = Post::with(['user:id,name','comments.user:id,name'])->find($id);
        return view('main2', compact('post', 'comments', 'settings'));
    }
}
