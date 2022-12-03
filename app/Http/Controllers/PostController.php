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
        $posts = Post::all();
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
        $post = Post::find($post->id);
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
        if (Auth::user()->id == $post->user_id){
            $post = Post::find($post->id);
            $tags = Tag::all();
            $categories = Category::all();
            return view('posts.edit', compact('post', 'tags', 'categories'));
        }else{
            return redirect(route('posts.index'));
        }
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
        if (Auth::user()->id == $post->user_id){
            $post = Post::find($post->id);
            $post->user_id = Auth::user()->id;
            $post->title = $request->title;
            $post->body = $request->content;
            $post->category_id = $request->category;
            $post->save();

            if(isset($request->tags)){
                $post->tags()->sync($request->tags);
            }
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
        if (Auth::user()->id == $post->user_id){
            $post->delete();
        }
        return redirect(route('posts.index'));
    }

}
