<?php

namespace Nika\LaravelComments\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComments
{
    protected static function bootHasComments(): void
    {
        static::deleting(function (Model $model) {
            if (! config('comments.delete_with_parent', false)) {
                if (app()->environment('local')) {
                    logger()->warning('delete_with_parent is disabled - comments will not be deleted with parent.');
                }

                return;
            }
            $model->comments()->delete();
        });
    }

    /*
     * Create a comment to this model.
     */

    public function comments(): MorphMany
    {
        return $this->morphMany(config('comments.comment_class'), 'commentable');
    }

    /*
     * Create a comment on this model as the specified user.
     */

    public function comment(string $comment): void
    {
        $this->commentAsUser(auth()->user(), $comment);
    }

    public function commentAsUser(?Model $user, string $comment): Model
    {
        if (! $user) {
            throw new \Illuminate\Auth\Access\AuthorizationException('User not specified');
        }
        $commentClass = config('comments.comment_class');

        $comment = new $commentClass([
            'user_id' => $user->getKey(),
            'comment' => $comment,
            'commentable_id' => $user->getKey(),
            'commentable_type' => get_class($this),
        ]);

        return $this->comments()->save($comment);
    }
}
