<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ParentChildComment
 *
 * @property int $parent_comment_id
 * @property int $child_comment_id
 * @method static \Illuminate\Database\Eloquent\Builder|ParentChildComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParentChildComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParentChildComment query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParentChildComment whereChildCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParentChildComment whereParentCommentId($value)
 * @mixin \Eloquent
 */
class ParentChildComment extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
}
