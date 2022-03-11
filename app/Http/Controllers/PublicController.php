<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PublicController extends Controller
{
    public function main(){
        $posts = Post::with('user')->get();
        return view('main', compact('posts'));
    }

    public function main_post($id){
        $post = Post::with(['user:id,name','comments.user:id,name'])->find($id);
        return view('main_post', compact('post'));
    }
}
