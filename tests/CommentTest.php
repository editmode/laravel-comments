<?php

use Illuminate\Auth\Access\AuthorizationException;
use Nika\LaravelComments\Models\Comment;
use Nika\LaravelComments\Tests\Models\Post;
use Nika\LaravelComments\Tests\Models\User;
use Nika\LaravelComments\Traits\HasComments;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

it('attaches a comment to a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $comment = $post->commentAsUser($user, 'This is a test comment');

    expect($comment)->toBeInstanceOf(Comment::class)
        ->and($post->comments->first()->body)->toBe('This is a test comment')
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

    actingAs($user = User::factory()->create());

    $post = Post::factory()->create();

    $post->commentAsUser($user, 'This is a test comment');

    expect(Post::count())->toBe(1)
        ->and(Comment::count())->toBe(1);

    $post->delete();

    expect(Post::count())->toBe(0)
        ->and(Comment::count())->toBe(0);
});

it('updates a comment', function () {
    Route::get('/login', fn () => 'login')
        ->name('login');

    actingAs($user = User::factory()->create());

    $post = Post::factory()->create();

    $comment = $post->commentAsUser($user, 'This is a test comment');

    expect(Comment::count())->toBe(1);

    patch(route('comment.update', $comment->id),
        ['body' => 'updated comment'])
        ->assertOk();

    expect($comment->fresh()->body)->toBe('updated comment');
});

it('creates comment from controller', function () {
    Route::get('/login', fn () => 'login')
        ->name('login');

    actingAs(User::factory()->create());

    $post = Post::factory()->create();

    post(route('comment.store'), [
        'commentable_id' => $post->id,
        'commentable_type' => Post::class,
        'body' => 'This is a test comment',
    ])
        ->assertOk();
    expect(Comment::count())->toBe(1)
        ->and(Comment::first()->body)->toBe('This is a test comment');
});

it('creates a reply', function () {

    Route::get('login', fn () => 'Login')
        ->name('login');

    $parentComment = new class extends Comment
    {
        use HasComments;

        protected $table = 'comments';
    };

    actingAs($user = User::factory()->create());

    $parentComment->fill([
        'user_id' => $user->id,
        'commentable_id' => 1,
        'commentable_type' => Post::class,
        'body' => 'Parent comment',
    ]);

    $parentComment->save();

    post(route('comment.store'), [
        'commentable_id' => $parentComment->id,
        'commentable_type' => get_class($parentComment),
        'body' => 'Replied comment',
    ])
        ->assertOk();

    expect(Comment::count())->toBe(2)
        ->and($parentComment->fresh()->comments()->first()->body)->toBe('Replied comment');
});
