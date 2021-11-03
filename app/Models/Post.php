<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $source_link
 * @property int $is_updated
 * @property int $view_count
 * @property int $type
 * @property int $game
 * @property string $content
 * @property int $like_count
 * @property int $dislike_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDislikeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereGame($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereLikeCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSourceLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereViewCount($value)
 * @mixin \Eloquent
 * @property string $text
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereText($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 */
class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
