<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactionRequest;
use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Post;
use App\Models\PostReaction;
use App\Models\Reaction;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;


class ReactionController extends Controller
{
//    public function commentReactionStore(ReactionRequest $request, $commentId)
//    {
//        try {
//            //if a reaction exists, update it
//            $reaction = \DB::table('comment_reactions')->updateOrInsert([
//                'comment_id' => $commentId,
//                'user_id' => auth()->user()->id,
//            ], ['reaction' => $request->reaction, 'updated_at' => now()]);
//        } catch (\Exception $exception) {
//            return response([
//                'message' => $exception->getMessage()
//            ], 400);
//        }
//
//        return response([
//            'message' => 'successfully reacted on comment',
//        ]);
//    }
//
//    // returns a list of users that reacted to the given comment with number of reactions
//    public function commentReactionsShow($commentId)
//    {
//        try {
//            if (\DB::table('comments')->where('id', $commentId)->exists()) {
//                $commentReactions = CommentReaction::select(['user_id', 'reaction'])->where('comment_id', $commentId)->get();
//
//                $reactionsCount = $commentReactions->count();
//
//                $likes = $commentReactions->where('reaction', 1)->count();
//                $dislikes = $commentReactions->where('reaction', 0)->count();
//
//            } else {
//                return response([
//                    'message' => 'comment doesn\'t exists'
//                ], 404);
//            }
//            if ($reactionsCount == 0) {
//                return response(['message' => 'no reactions']);
//            }
//        } catch (\Exception $exception) {
//            return response([
//                'message' => $exception->getMessage()
//            ], 400);
//        }
//        return response([
//            'message' => 'success',
//            'number_of_reactions' => $reactionsCount,
//            'likes' => $likes,
//            'dislikes' => $dislikes,
//            'reactions' => $commentReactions
//        ]);
//    }
//
//    public function postReactionStore(ReactionRequest $request, $postId)
//    {
//        try {
//            // if a reaction exists, update it
//            $reaction = \DB::table('post_reactions')->updateOrInsert([
//                'post_id' => $postId,
//                'user_id' => auth()->user()->id,
//            ], ['reaction' => $request->reaction, 'updated_at' => now()]);
//        } catch (\Exception $exception) {
//            return response([
//                'message' => $exception->getMessage()
//            ], 400);
//        }
//
//        return response([
//            'message' => 'successfully reacted on comment',
//        ]);
//    }
//
//    // returns a list of users that reacted to the given post with number of reactions
//    public function postReactionsShow($postId)
//    {
//        try {
//            if (\DB::table('posts')->where('id', $postId)->exists()) {
//                $postReactions = PostReaction::where('post_id', $postId)->get();
//                $reactionsCount = $postReactions->count();
//            } else {
//                return response([
//                    'message' => 'comment doesn\'t exists'
//                ], 404);
//            }
//            if ($reactionsCount == 0) {
//                return response(['message' => 'no reactions']);
//            }
//        } catch (\Exception $exception) {
//            return response([
//                'message' => $exception->getMessage()
//            ], 400);
//        }
//        return response([
//            'message' => 'success',
//            'number_of_reactions' => $reactionsCount,
//            'reactions' => $postReactions
//        ]);
//    }
//
//    public function reactionDestroy($entityId)
//    {
//        if (CommentReaction::where('comment_id', $entityId)->where('user_id', auth()->user()->id)->exists()) {
//            CommentReaction::where('comment_id', $entityId)->where('user_id', auth()->user()->id)->delete();
//        } elseif (PostReaction::where('post_id', $entityId)->where('user_id', auth()->user()->id)->exists()) {
//            PostReaction::where('post_id', $entityId)->where('user_id', auth()->user()->id)->delete();
//        } else {
//            return response([
//                'message' => 'reaction doesn\'t exist'
//            ]);
//        }
//        return response(['message' => 'reaction deleted successfully']);
//    }

    public function store(ReactionRequest $reactionRequest, int $entityId)
    {
        $types = ['post' => Post::class, 'comment' => Comment::class];

        $reactionType = $reactionRequest->reactionable_type;


        if ($types[$reactionType] == $types['post']) {


            $reaction = Post::findOrFail($entityId)->reactions();

            $reaction->updateOrInsert([
                'reactionable_id' => $entityId,
                'user_id' => auth()->user()->id,
            ], ['reaction' => $reactionRequest->reaction, 'reactionable_type' => $types['post'], 'created_at' => now()]);

        } elseif ($types[$reactionType] == $types['comment']) {

            $reaction = Comment::find($entityId)->reactions();

            $reaction->updateOrInsert([
                'reactionable_id' => $entityId,
                'user_id' => auth()->user()->id,
            ], ['reaction' => $reactionRequest->reaction, 'reactionable_type' => $types['comment'], 'created_at' => now()]);
        }

        return response([
            'message' => 'reacted successfully'
        ], 201);
    }

    public function commentStore(ReactionRequest $request, Comment $comment)
    {
        if (!$comment->exists()) {
            return response([
                'error' => 'comment doesn\'t exist'
            ]);
        }


    }

    public function indexPost(Post $post)
    {
        if (!$post->exists()) {
            return response([
                'error' => 'comment doesn\'t exist'
            ]);
        }

        $reactions = $post->reactions()->where('reactionable_type', Post::class)->get();
        $likes = $reactions->where('reaction', 1)->count();
        $dislikes = $reactions->where('reaction', 0)->count();

        return response([
            'post_id' => $post->id,
            'likes' => $likes,
            'dislikes' => $dislikes
        ]);

    }

    public function indexComment(Comment $comment)
    {
        if (!$comment->exists()) {
            return response([
                'error' => 'comment doesn\'t exist'
            ]);
        }


        $reactions = $comment->reactions()->where('reactionable_type', Comment::class)->get();
        $likes = $reactions->where('reaction', 1)->count();
        $dislikes = $reactions->where('reaction', 0)->count();

        return response([
            'comment_id' => $comment->id,
            'likes' => $likes,
            'dislikes' => $dislikes
        ]);

    }

    public function index(Request $request, $model, $entityId)
    {
        $types = ['posts' => Post::class, 'comments' => Comment::class];


        if (!in_array($model, array_keys($types))) {

            return response([
                'error' => 'model not supported'
            ], 400);
        }
        $types[$model] == $types['posts'] ? $model = Post::findOrFail($entityId)->reactions()->get() : $model = Comment::findOrFail($entityId)->reactions()->get();

        $userReaction = 'unauthorized';

        if (auth()->check()) $userReaction = $model->where('user_id', $request->user()->id)->pluck('reaction');


        $likes = $model->where('reaction', 1)->count();
        $dislikes = $model->where('reaction', 0)->count();


        return response([
            'likes' => $likes,
            'dislikes' => $dislikes,
            'user_reaction' => $userReaction

        ]);

    }

    public function destroy($model, $id)
    {

        $allowed = ['posts', 'comments'];
        $userId = auth()->user()->id;
        if (!in_array($model, $allowed)) {
            return response([
                'error' => 'model doesn\'t exist'
            ], 400);
        }

        if ($model == 'posts') {
            $post = Post::findOrFail($id);
            $reaction = $post->reactions()->where('user_id', $userId);
            if (!$reaction->exists()) return response(['error' => 'reaction doesn\'t exist'], 404);
            $reaction->delete();
        } elseif ($model == 'comments') {
            $comment = Comment::findOrFail($id);
            $reaction = $comment->reactions()->where('user_id', $userId);
            if (!$reaction->exists()) return response(['error' => 'reaction doesn\'t exist'], 404);
            $reaction->delete();
        }

        return response([
            'success' => 'reaction deleted successfully'
        ]);


    }
}
