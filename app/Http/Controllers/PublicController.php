<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Comment;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Auth;

class PublicController extends Controller
{
    public function main(){
        $user = auth()->user();
        if ($user == null){
            $posts = Post::with('user')->orderBy('id', 'DESC')->paginate(15);
            return view('main', compact('posts'));
        }else{
            if($user->email_verified_at != null){
                $posts = Post::with('user')->orderBy('id', 'DESC')->paginate(15);
                return view('main', compact('posts'));
            }else{
                Auth::logout();
                return redirect('/email/verify');
            }
        }
    }

    public function singlePost($id){
        $settings = Setting::find(1);
        $file = Document::where('postid', $id)->first();
        $post = Post::where('id', $id)->with(['user','comments', 'tags'])->first();
        return view('singlepost', compact('post', 'settings', 'file'));
    }

    public function fileDownload($id){
        $doc = Document::find($id);
        $content = Storage::disk('public')->download("uploads/".$doc->postid."/".$doc->name);
        return $content;
    }
}
