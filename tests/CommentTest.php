<?php

use Illuminate\Auth\Access\AuthorizationException;
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

it('prevents unauthorized users from commenting', function () {
    $post = Post::factory()->create();

    expect(fn () => $post->commentAsUser(null, 'This is a test comment'))
        ->toThrow(AuthorizationException::class);
});

it('deletes associated comments when delete_with_parent config is enabled', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $post->commentAsUser($user, 'This is a test comment');

    expect(Comment::count())->toBe(1);

    $post->delete();

    expect(Comment::count())->toBe(0)
        ->and(Post::count())->toBe(0);
});
