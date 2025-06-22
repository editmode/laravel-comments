<?php

namespace Nika\LaravelComments\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nika\LaravelComments\Events\CommentDeleted;
use Nika\LaravelComments\Models\Comment;

trait HasComments
{
    protected static function bootHasComments(): void
    {
        static::deleting(function (Model $model) {
            // Handle reply deletion if the model is a Comment
            if (
                $model instanceof Comment &&
                config('comments.delete_replies_on_comment_deletion', false)
            ) {
                $model->comments()->delete();
            }

            // Handle parent model comment deletion
            if (! config('comments.delete_with_parent', false)) {
                if (app()->environment('local')) {
                    logger()->warning('delete_with_parent is disabled - comments will not be deleted with parent.');
                }

                return;
            }

            // Only delete comments of non-Comment models (e.g., Post, User)
            if (! ($model instanceof Comment)) {
                $model->comments()->delete();
            }
        });

        static::deleted(function (Model $model) {
            if ($model instanceof Comment) {
                CommentDeleted::dispatch($model);
            }
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

        if (strlen($comment) > 1000) {
            throw new \InvalidArgumentException('Comment cannot have more than 1000 characters');
        }

        $comment = new $commentClass([
            'user_id' => $user->getKey(),
            'body' => $comment,
            'commentable_id' => $user->getKey(),
            'commentable_type' => get_class($this),
        ]);

        return $this->comments()->save($comment);
    }
}
