<?php

namespace Nika\LaravelComments\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nika\LaravelComments\Models\Comment;

class CommentAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Comment $comment
    )
    {
    }
}
