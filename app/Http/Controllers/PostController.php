<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use Exception;

class PostController extends Controller
{
    // get titles with the number of comments
    public function index()
    {
        $titles = Post::select(['id', 'title', 'created_at'])->orderBy('created_at')->withCount('comments')->get();

        return response([
            'message' => 'Success',
            'titles' => $titles
        ], 200);
    }

    public function showById($id)
    {

        return response([
                'message' => 'success',
                'post' => Post::where('id', $id)->get()
            ]
        );
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
                'view_count' => 0
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
