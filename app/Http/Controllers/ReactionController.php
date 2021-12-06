<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactionRequest;
use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\PostReaction;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function commentReactionStore(ReactionRequest $request, $commentId)
    {
        try {
            //if a reaction exists, update it
            $reaction = \DB::table('comment_reactions')->updateOrInsert([
                'comment_id' => $commentId,
                'user_id' => auth()->user()->id,
            ], ['reaction' => $request->reaction, 'updated_at' => now()]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response([
            'message' => 'successfully reacted on comment',
        ]);
    }

    // returns a list of users that reacted to the given comment with number of reactions
    public function commentReactionsShow($commentId)
    {
        try {
            if (\DB::table('comments')->where('id', $commentId)->exists()) {
                $commentReactions = CommentReaction::select(['user_id', 'reaction'])->where('comment_id', $commentId)->get();
                $reactionsCount = $commentReactions->count();
                $likes = $commentReactions->where('reaction', 1)->count();
                $dislikes = $commentReactions->where('reaction', 0)->count();

            } else {
                return response([
                    'message' => 'comment doesn\'t exists'
                ], 404);
            }
            if ($reactionsCount == 0) {
                return response(['message' => 'no reactions']);
            }
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        return response([
            'message' => 'success',
            'number_of_reactions' => $reactionsCount,
            'likes' => $likes,
            'dislikes' => $dislikes,
            'reactions' => $commentReactions
        ]);
    }

    public function postReactionStore(ReactionRequest $request, $postId)
    {
        try {
            //if a reaction exists, update it
            $reaction = \DB::table('post_reactions')->updateOrInsert([
                'post_id' => $postId,
                'user_id' => auth()->user()->id,
            ], ['reaction' => $request->reaction, 'updated_at' => now()]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response([
            'message' => 'successfully reacted on comment',
        ]);
    }

    // returns a list of users that reacted to the given post with number of reactions
    public function postReactionsShow($postId)
    {
        try {
            if (\DB::table('posts')->where('id', $postId)->exists()) {
                $postReactions = PostReaction::where('post_id', $postId)->limit(10)->get();
                $reactionsCount = $postReactions->count();
            } else {
                return response([
                    'message' => 'comment doesn\'t exists'
                ], 404);
            }
            if ($reactionsCount == 0) {
                return response(['message' => 'no reactions']);
            }
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
        return response([
            'message' => 'success',
            'number_of_reactions' => $reactionsCount,
            'reactions' => $postReactions
        ]);
    }

    public function reactionDestroy($entityId)
    {
        if (CommentReaction::where('comment_id', $entityId)->where('user_id', auth()->user()->id)->exists()) {
            CommentReaction::where('comment_id', $entityId)->where('user_id', auth()->user()->id)->delete();
        } else {
            return response([
                'message' => 'reaction doesn\'t exist'
            ]);
        }
        return response(['message' => 'reaction deleted successfully']);
    }
}
