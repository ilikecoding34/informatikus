<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

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
        $post = Post::where('id', $id)->with('comments')->get();
        return response($post, 200);
    }

    public function newpost(Request $request){
        $post = new Post;
        $post->save();

        return response($post, 201);
    }

}
