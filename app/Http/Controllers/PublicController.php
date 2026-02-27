<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Setting;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Auth;
use Str;

class PublicController extends Controller
{
    public function main(Request $request)
    {
        if (Str::contains($request->header('User-Agent'), 'Android') || Str::contains($request->header('User-Agent'), 'iPhone')) {
            return redirect('https://m.informatikusleszek.hu/#/');
        }

        $user = auth()->user();
        if ($user === null) {
            return $this->mainPageResponse(null);
        }
        if ($user->email_verified_at === null) {
            Auth::logout();
            return redirect('/email/verify');
        }
        return $this->mainPageResponse($user);
    }

    private function mainLayoutData($user)
    {
        $newestPosts = Post::active()->with('user', 'tags')->orderBy('id', 'DESC')->limit(5)->get();
        $mostViewedPosts = Post::active()->with('user', 'tags')->orderByViews('desc')->limit(10)->get();
        $categoriesWithCount = Category::withCount('posts')->orderBy('name')->get();
        $recentComments = Comment::visible()->with('user', 'post')->latest()->limit(10)->get();

        $leftSidebar = 'newest';
        $rightSidebar = 'most_viewed';
        if ($user) {
            $setting = Setting::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'show_left_column' => true,
                    'show_right_column' => true,
                    'left_sidebar' => 'newest',
                    'right_sidebar' => 'most_viewed',
                    'col_count' => 3,
                    'col_post' => 2,
                    'col_related' => null,
                    'col_comment' => null,
                ]
            );
            $leftSidebar = $setting->left_sidebar ?? 'newest';
            $rightSidebar = $setting->right_sidebar ?? 'most_viewed';
        }
        $showLeft = $leftSidebar !== '' && $leftSidebar !== null;
        $showRight = $rightSidebar !== '' && $rightSidebar !== null;

        return compact(
            'newestPosts',
            'mostViewedPosts',
            'categoriesWithCount',
            'recentComments',
            'leftSidebar',
            'rightSidebar',
            'showLeft',
            'showRight'
        );
    }

    private function mainPageResponse($user)
    {
        $tags = Tag::all();
        $posts = Post::active()->with('user', 'tags', 'comments')->orderBy('id', 'DESC')->paginate(20);
        $layout = $this->mainLayoutData($user);
        return view('main', array_merge(compact('posts', 'tags'), $layout));
    }

    public function category($id)
    {
        $tags = Tag::all();
        $posts = Post::active()->with('user', 'tags', 'comments')
            ->whereHas('tags', function ($query) use ($id) {
                $query->where('name', $id);
            })->orderBy('id', 'DESC')->paginate(20);
        $layout = $this->mainLayoutData(auth()->user());
        return view('main', array_merge(compact('posts', 'tags'), $layout));
    }

    public function byCategory($id)
    {
        $tags = Tag::all();
        $posts = Post::active()->with('user', 'tags', 'comments')
            ->where('category_id', $id)
            ->orderBy('id', 'DESC')
            ->paginate(20);
        $layout = $this->mainLayoutData(auth()->user());
        return view('main', array_merge(compact('posts', 'tags'), $layout));
    }

    public function singlePost($id)
    {
        $post = Post::where('id', $id)->with('user', 'updatedBy', 'comments', 'tags')->first();
        if (!$post || !$post->is_active) {
            abort(404);
        }
        $settings = Setting::find(1);
        $file = Document::where('postid', $id)->first();
        if (url()->current() != url()->previous()) {
            views($post)->record();
        }
        return view('singlepost', compact('post', 'settings', 'file'));
    }

    public function fileDownload($id){
        $doc = Document::find($id);
        $content = Storage::disk('public')->download("uploads/".$doc->postid."/".$doc->name);
        return $content;
    }
}
