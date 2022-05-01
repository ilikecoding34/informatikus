<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class APIController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
         ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    function login(Request $request)
    {
        $user= User::where('email', $request->email)->first();

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

             return response($response, 200);
    }

    public function posts(){
        $posts = Post::with('user')->get();
        return response()->json($posts, 200);
    }

    public function getpost($id){
        $post = Post::where('id', $id)->with(['user','comments'])->first();
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
