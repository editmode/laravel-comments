<?php

namespace Nika\LaravelComments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentLike extends Model
{
    protected $fillable = [
        'comment_id',
        'user_id',
        'is_like',
    ];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(config('comments.comment_class'));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}
