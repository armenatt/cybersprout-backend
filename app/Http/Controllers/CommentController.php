<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\ParentChildComment;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

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
            if (Comment::where('id', $parentCommentId)->exists()) {
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
            } else {
                return response([
                    'message' => 'Commentg doesn\'t exist',

                ], 404);
            }

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

    public function showReplies($postId, $parentCommentId)
    {
        try {
            $replies = DB::table('comments')
                ->join('parent_child_comments', 'parent_child_comments.child_comment_id', '=', 'comments.id')
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
            'replies' => $replies
        ]);
    }


}
