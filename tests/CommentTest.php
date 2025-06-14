<?php

use Nika\LaravelComments\Models\Comment;
use Nika\LaravelComments\Tests\Models\Post;
use Nika\LaravelComments\Tests\Models\User;

it('attaches a comment to a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $comment = $post->commentAsUser($user, 'This is a test comment');

    expect($comment)->toBeInstanceOf(Comment::class)
        ->and($post->comments->first()->comment)->toBe('This is a test comment')
        ->and($post->comments)->toHaveCount(1);
});
