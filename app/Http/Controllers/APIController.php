<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class APIController extends Controller
{
    function index(Request $request)
    {
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }

             $token = $user->createToken('my-app-token')->plainTextToken;

            $response = [
                'token' => $token,
                'user_id' => $user->id
            ];
      //          return $token;
             return response($response, 200);
    }

    function users(Request $request)
    {
        $user= User::find(1);
        $response = $user;

        return response($response, 200);
    }

    public function posts(){
        $posts = Post::all();
        return response()->json($posts, 200);
    }

    public function getpost($id){
        $post = Post::where('id', $id)->with('comments')->first();
        return response($post, 200);
    }

    public function newpost(Request $request){
        $post = new Post;
        $post->user_id = $request->userid;
        $post->title = $request->title;
        $post->link = $request->link;
        $post->body = $request->content;
        $post->category_id = $request->category;
        $post->save();

        return response($post, 201);
    }

    public function modifypost(Request $request){
        $post = Post::find($request->id);
        $post->title = $request->title;
        $post->link = $request->link;
        $post->body = $request->content;
        $post->category_id = $request->category;
        $post->save();

        return response($post, 201);
    }

    public function newcomment(Request $request){
        $comment = new Comment;
        $comment->user_id = $request->userid;
        $comment->body = $request->content;
        $comment->post_id = $request->postid;
        $comment->save();

        $post = Post::find($request->postid);

        return response($post, 200);
    }

    public function modifycomment(Request $request){
        $comment = Comment::find($request->id);
        $comment->body = $request->content;
        $comment->save();

        $post = Post::find($request->postid);

        return response($post, 200);
    }

    public function deletecomment(Request $request){
        $comment = Comment::find($request->commentid);
        $comment->delete();

        $post = Post::find($request->postid);

        return response($post, 200);
    }

}
