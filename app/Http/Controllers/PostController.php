<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $latestNews = Post::orderBy('created_at', 'desc')->simplePaginate(25);
        return $latestNews;
    }

    public function store(PostRequest $request)
    {
        try {
            $newPost = Post::create([
                'author_id' => auth()->user()->id,
                'title' => $request->title,
                'source_link' => $request->source_link,
                'is_updated' => 0,
                'type' => $request->type,
                'game' => $request->game,
                'text' => $request->text,
                'like_count' => 0,
                'dislike_count' => 0,
                'view_count' => 1
            ]);
            return response([
                'message' => 'Success',
                'post' => $newPost,

            ], 200);
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

    }
}
