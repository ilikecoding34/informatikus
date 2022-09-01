<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Document;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use Carbon\Carbon;
use App\Mail\NotifyMail;
use App\Mail\VerifyMail;

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
        $randnumber = random_int(1000, 9999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'secret_code' => $randnumber
         ]);

        $token = $user->createToken('my-app-token')->plainTextToken;

        Mail::to('fejdav@gmail.com')->send(new NotifyMail($user));
        Mail::to($request->email)->send(new VerifyMail($randnumber));

        return response()
            ->json(['user_id' => $user->id,'access_token' => $token, 'token_type' => 'Bearer', ]);
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

    public function verify($id, $code){
        $user = User::find($id);
        if($user->secret_code == $code){
            $user->email_verified_at = Carbon::now();
            $user->save();
            return response()->json('success', 200);
        }else{
            return response()->json('failed', 200);
        }
    }

    public function lateverify(Request $request){
        $user = User::where('email', $request->email)->first();
        if($user->secret_code == $request->code){
            $user->email_verified_at = Carbon::now();
            $user->save();
            return response()->json('success', 200);
        }else{
            return response()->json('failed', 200);
        }
    }

    public function posts(){
        $posts = Post::with('user')->orderBy('id', 'DESC')->get();
        return response()->json($posts, 200);
    }

    public function postswithtags(){
        $posts = Post::with('user', 'tags')->orderBy('id', 'DESC')->get();
        $tag = Tag::all();
        return response()->json([$posts, $tag], 200);
    }

    public function getpost($id){
        $post = Post::where('id', $id)->with(['user','comments', 'tags', 'file'])->first();
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

        $post->tags()->attach($request->tags);

        $request->validate([
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf,jpeg,jpg,png,gif|required|max:10000'
            ]);

        $fileModel = new Document;

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads/'.$post->id.'/', $fileName, 'public');
            $fileModel->userid = 1;
            $fileModel->postid = $post->id;
            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();
        }

        return response($post, 201);
    }

    public function fileDownload($id){
        $doc = Document::find($id);
        return response($doc->file_path, 200);
    }

    public function modifypost(Request $request){
        $post = Post::find($request->id);
        $post->title = $request->title;
        $post->link = $request->link;
        $post->body = $request->content;
        $post->category_id = $request->category;
        $post->save();

        $post->tags()->sync($request->tags);

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
