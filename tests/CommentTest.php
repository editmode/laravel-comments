<?php

use Illuminate\Auth\Access\AuthorizationException;
use Nika\LaravelComments\Models\Comment;
use Nika\LaravelComments\Tests\Models\Post;
use Nika\LaravelComments\Tests\Models\User;

use function Pest\Laravel\actingAs;

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

    Route::get('/login', fn () => 'login')
        ->name('login');

    config()->set('comments.delete_with_parent', true);

    $user = User::factory()->create();
    actingAs($user);

    $post = Post::factory()->create();

    $post->commentAsUser($user, 'This is a test comment');

    expect(Post::count())->toBe(1)
        ->and(Comment::count())->toBe(1);

    $post->delete();

    expect(Post::count())->toBe(0)
        ->and(Comment::count())->toBe(0);
});
