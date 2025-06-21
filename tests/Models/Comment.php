<?php

namespace Nika\LaravelComments\Tests\Models;

use Nika\LaravelComments\Models\Comment as BaseComment;
use Nika\LaravelComments\Traits\HasComments;
use Nika\LaravelComments\Traits\HasReactions;

class Comment extends BaseComment
{
    use HasComments, HasReactions;
}
