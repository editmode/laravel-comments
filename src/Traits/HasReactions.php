<?php

namespace Nika\LaravelComments\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Nika\LaravelComments\Models\CommentReaction;

trait HasReactions
{
    public function likeCount(): int
    {
        return $this->reactions()->where('type', 'like')->count();
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function dislikeCount(): int
    {
        return $this->reactions()->where('type', 'dislike')->count();
    }
}
