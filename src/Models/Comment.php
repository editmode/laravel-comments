<?php

namespace Nika\LaravelComments\Models;

use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
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

    public function deleteComment(?Authenticatable $user, int $commentId): void
    {
        abort_if(! $user, 403);

        $commentClass = config('comments.comment_class');
        $comment = app($commentClass)->findOrFail($commentId);

        abort_unless(($user->getAuthIdentifier()) === $comment->user_id, 403);

        $comment->delete();
    }
}
