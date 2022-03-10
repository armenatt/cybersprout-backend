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

        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        return response([
            'message' => 'successfully commented',
            'comment' => $newComment
        ]);
    }

    public function index($postId)
    {
        try {
            // $comments = Comment::where('post_id', $postId)->limit(25)->get();
            $comments = Comment::with('childrenRecursive')
                ->where('post_id', $postId)
                ->whereNull('parent_id')
                ->paginate();
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response([
            'message' => 'success',
            'comments' => $comments
        ]);
    }

    public function storeReply(CommentRequest $request, int $postId, int $parentCommentId)
    {
        try {
            if (Comment::where('id', $parentCommentId)->exists()) {
                $newReply = Comment::create([
                    'author_id' => auth()->user()->id,
                    'parent_id' => $parentCommentId,
                    'like_count' => 0,
                    'dislike_count' => 0,
                    'text' => $request->text,
                    'attachment' => $request->attachment,
                    'post_id' => $postId,
                    'is_updated' => 0,
                    'is_hidden' => 0
                ]);

//                ParentChildComment::create([
//                    'parent_comment_id' => $parentCommentId,
//                    'child_comment_id' => $newReply->id
//                ]);
            } else {
                return response([
                    'message' => 'Reply failed: parent comment doesn\'t exist',

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

//    public function showReplies($postId, $parentCommentId)
//    {
//        try {
//            $replies = DB::table('comments')
//                ->join('parent_child_comments', 'parent_child_comments.child_comment_id', '=', 'comments.id')
//                ->where('parent_child_comments.parent_comment_id', $parentCommentId)->get();
//            $replyCount = $replies->count();
//            if ($replyCount == 0) return response([
//                'message' => 'no replies'
//            ], 404);
//        } catch (\Exception $exception) {
//            return response([
//                'message' => $exception->getMessage()
//            ], 400);
//        }
//
//        return response([
//            'message' => 'success',
//            'reply_count' => $replyCount,
//            'replies' => $replies
//        ]);
//    }


}
