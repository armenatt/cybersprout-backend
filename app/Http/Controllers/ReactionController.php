<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactionRequest;
use App\Models\CommentReaction;
use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function commentReactionStore(ReactionRequest $request, $commentId)
    {
        try {
            $reaction = \DB::table('comment_reactions')->updateOrInsert([
                'comment_id' => $commentId,
                'user_id' => auth()->user()->id,
            ], ['reaction' => $request->reaction]);
        } catch (\Exception $exception) {
            return response([
                'message' => $exception->getMessage()
            ], 400);
        }

        return response([
            'message' => 'successfully reacted on comment',
        ]);
    }
}
