<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\QuckNewsRequest;
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

    public function show($id)
    {
        try {
            if (!Post::where('id', $id)->exists()) {
                return response([
                    'message' => 'post doesn\'t exist'
                ], 404);
            }
            $post = Post::where('id', $id)->get();
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response([
                'message' => 'success',
                'post' => $post
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

        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        return response([
            'message' => 'Success',
            'post' => $newPost,

        ], 200);

    }

    public function quickNewsStore(QuckNewsRequest $request)
    {
        try {
            $quickNews = Post::create([
                'author_id' => auth()->user()->id,
                'is_updated' => 0,
                'view_count' => 0,
                'like_count' => 0,
                'dislike_count' => 0,
                'title' => $request->title,
                'text' => $request->text,
                'type' => 1,
                'attachment' => $request->attachment
            ]);
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage(),
            ], 400);
        }
        return response([
            'message' => 'successfully posted a quicknews',
            'quick_news' => $quickNews
        ]);
    }

    //this gets all the articles with type 1 (quicknews)
    public function quickNewsIndex()
    {
        try {
            $quickNews = Post::with(['reactions'])
                ->select(['posts.id', 'title', 'text', 'attachment_reference'])
                ->leftJoin('attachments', 'posts.attachment', '=', 'attachments.id')
                ->where('type', 1)
                ->limit(10)
                ->orderByDesc('posts.created_at')
                ->get();
        } catch (Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        return response([
            'message' => 'success',
            'quick_news' => $quickNews
        ]);
    }
}
