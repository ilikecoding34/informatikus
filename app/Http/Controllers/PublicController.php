<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Comment;
use Auth;

class PublicController extends Controller
{
    public function main(){
        $user = auth()->user();
        if ($user == null){
            $posts = Post::with('user')->orderBy('id', 'DESC')->get();
            return view('main', compact('posts'));
        }else{
            if($user->email_verified_at != null){
                $posts = Post::with('user')->orderBy('id', 'DESC')->get();
                return view('main', compact('posts'));
            }else{
                Auth::logout();
                return redirect('/email/verify');
            }
        }
    }

    public function main_post($id){
        $settings = Setting::find(1);
        $post = Post::where('id', $id)->with(['user','comments', 'tags'])->first();
        return view('main2', compact('post', 'settings'));
    }
}
