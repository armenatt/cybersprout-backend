<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\ParentChildComment;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{

    public function store(CommentRequest $request, $postId)
    {
        try {
            $newComment = Comment::create([
                'author_id' => auth()->user()->id,
                'like_count' => 0,
                'dislike_count' => 0,
                'text' => $request->text,
                'attachment' => $request->attachment,
                'post_id' => $postId,
                'is_updated' => 0,
                'is_hidden' => 0
            ]);

//            ParentChildComment::create([
//                'parent_comment_id' => $newComment->id,
//                'child_comment_id' => $newComment->id
//            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        return response([
            'message' => 'successfully commented',
            'comment' => $newComment
        ], 200);
    }

    public function storeReply(CommentRequest $request, $postId, $parentCommentId)
    {
        try {
            $newReply = Comment::create([
                'author_id' => auth()->user()->id,
                'like_count' => 0,
                'dislike_count' => 0,
                'text' => $request->text,
                'attachment' => $request->attachment,
                'post_id' => $postId,
                'is_updated' => 0,
                'is_hidden' => 0
            ]);

            ParentChildComment::create([
                'parent_comment_id' => $parentCommentId,
                'child_comment_id' => $newReply->id
            ]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        return response([
            'message' => 'successfully replied',
            'reply' => $newReply
        ], 200);

    }

    public function show($postId)
    {
        try {
            $firstLevelComments = Comment::where('post_id', $postId)->limit(25)->get();
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response([
            'message' => 'success',
            'comments' => $firstLevelComments
        ]);
    }

    public function showReply($postId, $parentCommentId)
    {
        try {
            $replies = DB::table('parent_child_comments')
                ->join('comments', 'parent_child_comments.child_comment_id', '=', 'comments.id')
                ->where('parent_child_comments.parent_comment_id', $parentCommentId)->get();
            $replyCount = $replies->count();

        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        return response([
            'message' => 'success',
            'reply_count' => $replyCount,
            'parent_comment_id' => $parentCommentId,
            'replies' => $replies
        ]);
    }


}