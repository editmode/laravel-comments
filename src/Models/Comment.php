<?php

namespace Nika\LaravelComments\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Nika\LaravelComments\Traits\HasReactions;

class Comment extends Model
{
    use HasReactions;

    protected $fillable = [
        'user_id',
        'comment',
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @throws Exception
     */
    public function commenter(): BelongsTo
    {
        return $this->belongsTo($this->getAuthModelName(), 'user_id');
    }

    /**
     * @throws Exception
     */
    protected function getAuthModelName()
    {
        return config('comments.user_model')
            ?? config('auth.providers.users.model')
            ?? throw new Exception('Could not determine user model name');
    }
}
