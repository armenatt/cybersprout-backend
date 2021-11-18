<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactionRequest;
use App\Models\Comment;
use App\Models\CommentReaction;
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
                $commentReactions = CommentReaction::where('comment_id', $commentId)->limit(10)->get();
                $reactionsCount = $commentReactions->count();
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
            'reactions' => $commentReactions
        ]);
    }
}
