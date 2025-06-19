<?php

namespace Nika\LaravelComments;

class LaravelComments
{
    public static function isReactionsEnabled(): bool
    {
        return config('comments.like_dislike_feature', false);
    }
}
