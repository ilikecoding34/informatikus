<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Document;
use Auth;

use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['user', 'updatedBy', 'tags'])->withCount('comments')->orderBy('id', 'desc')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('posts.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;

        $post = new Post;
        $post->user_id = $user_id;
        $post->updated_by_id = $user_id;
        $post->title = $request->title;
        $post->link = $request->link;
        $post->body = $request->content;
        $post->category_id = $request->category;

        $post->save();

        if($request->file('file')) {

            $request->validate([
                'file' => 'required|mimes:csv,txt,xlx,xls,pdf,jpeg,jpg,png,gif|required|max:10000'
            ]);

            $fileModel = new Document;

            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads/'.$post->id, $fileName, 'public');
            $fileModel->userid = $user_id;
            $fileModel->postid = $post->id;
            $fileModel->name = $fileName;
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();
        }

        if(isset($request->tags)){
            $post->tags()->attach($request->tags);
        }

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->with('comments');
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (!Auth::user()->canEditPost($post)) {
            return redirect(route('posts.index'));
        }
        $post = Post::find($post->id);
        $tags = Tag::all();
        $categories = Category::all();
        return view('posts.edit', compact('post', 'tags', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (!Auth::user()->canEditPost($post)) {
            return redirect(route('posts.index'));
        }
        $post = Post::find($post->id);
        $post->updated_by_id = Auth::user()->id;
        $post->title = $request->title;
        $post->link = $request->link ?? $post->link;
        $post->body = $request->content;
        $post->category_id = $request->category;
        $post->save();

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags);
        }

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (!Auth::user()->canEditPost($post)) {
            return redirect(route('posts.index'));
        }
        $post->delete();
        return redirect(route('posts.index'));
    }

    public function deactivate(Post $post)
    {
        if (!Auth::user()->canEditPost($post)) {
            return redirect(route('posts.index'));
        }
        $post->update(['is_active' => false]);
        return redirect(route('posts.index'))->with('message', 'Bejegyzés deaktiválva.');
    }

    public function activate(Post $post)
    {
        if (!Auth::user()->canEditPost($post)) {
            return redirect(route('posts.index'));
        }
        $post->update(['is_active' => true]);
        return redirect(route('posts.index'))->with('message', 'Bejegyzés aktiválva.');
    }
}
