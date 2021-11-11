<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CommentReaction
 *
 * @property int $user_id
 * @property int $comment_id
 * @property int $reaction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReaction whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReaction whereReaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReaction whereUserId($value)
 * @mixin \Eloquent
 */
class CommentReaction extends Model
{
    use HasFactory;

    protected $guarded = [];
}
