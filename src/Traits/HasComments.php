<?php

namespace Nika\LaravelComments\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComments
{
    /*
     * Create a comment to this model.
     */
    public function comment(string $comment): void
    {
        $this->commentAsUser(auth()->user(), $comment);
    }

    /*
     * Create a comment on this model as the specified user.
     */
    public function commentAsUser(?Model $user, string $comment): Model
    {
        $commentClass = config('comments.comment_class');

        $comment = new $commentClass([
            'user_id' => is_null($user) ? null : $user->getKey(),
            'comment' => $comment,
            'commentable_id' => $user->getKey(),
            'commentable_type' => get_class($this),
        ]);

        return $this->comments()->save($comment);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(config('comments.comment_class'), 'commentable');
    }
}
