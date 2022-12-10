<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Setting;
use App\Models\Comment;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Auth;
use Str;

class PublicController extends Controller
{
    public function main(Request $request){
        if(Str::contains($request->header('User-Agent'), 'Android') || Str::contains($request->header('User-Agent'), 'iPhone')){
            return redirect('https://m.informatikusleszek.hu/#/');
        }

        $user = auth()->user();
        if ($user == null){
            $tags = Tag::all();
            $posts = Post::with('user','tags', 'comments')->orderBy('id', 'DESC')->paginate(20);
            return view('main', compact('posts','tags'));
        }else{
            if($user->email_verified_at != null){
                $tags = Tag::all();
                $posts = Post::with('user','tags', 'comments')->orderBy('id', 'DESC')->paginate(20);
                return view('main', compact('posts','tags'));
            }else{
                Auth::logout();
                return redirect('/email/verify');
            }
        }
    }

    public function category($id){
        $tags = Tag::all();
        $posts = Post::with('user', 'tags', 'comments')
            ->whereHas('tags', function ($query) use($id) {
                $query->where('name', $id);
            })->orderBy('id', 'DESC')->paginate(20);
        return view('main', compact('posts','tags'));
    }

    public function singlePost($id){
        $settings = Setting::find(1);
        $file = Document::where('postid', $id)->first();
        $post = Post::where('id', $id)->with('user','comments', 'tags')->first();
        if(url()->current() != url()->previous()){
            $post->increment('view');
        }
        views($post)->record();
        return view('singlepost', compact('post', 'settings', 'file'));
    }

    public function fileDownload($id){
        $doc = Document::find($id);
        $content = Storage::disk('public')->download("uploads/".$doc->postid."/".$doc->name);
        return $content;
    }
}
