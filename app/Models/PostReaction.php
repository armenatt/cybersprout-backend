<?php

namespace App\Models;

use App\Http\Controllers\PostController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostReaction
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PostReaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostReaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostReaction query()
 * @mixin \Eloquent
 * @property int $user_id
 * @property int $post_id
 * @property int $reaction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PostReaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostReaction wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostReaction whereReaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostReaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostReaction whereUserId($value)
 * @property-read \App\Models\Post $post
 */
class PostReaction extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
