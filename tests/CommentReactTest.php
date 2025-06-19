<?php

use Nika\LaravelComments\Tests\Models\Post;
use Nika\LaravelComments\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\post;

beforeEach(function () {
    config()->set('comments.like_dislike_feature', true);
    Route::comments();
});

it('accepts only like or dislike as valid reaction type', function () {

    $user = User::factory()->create();

    actingAs($user);

    $post = Post::factory()->create();

    $comment = $post->commentAsUser($user, 'This is a Test comment');

    post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'like']))
        ->assertOk();

    post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'randomType']))
        ->assertNotFound();

    post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'dislike']))
        ->assertOk();
});

it('toggles comment like reaction', function () {

    $user = User::factory()->create();
    actingAs($user);

    $post = Post::factory()->create();

    $comment = $post->commentAsUser($user, 'This is a Test comment');

    assertDatabaseEmpty('comment_reactions');

    post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'like']))
        ->assertOk();

    assertDatabaseCount('comment_reactions', 1);

    post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'like']))
        ->assertOk();

    assertDatabaseEmpty('comment_reactions');
});

it('toggles comment dislike reaction', function () {

    $user = User::factory()->create();
    actingAs($user);

    $post = Post::factory()->create();

    $comment = $post->commentAsUser($user, 'This is a Test comment');

    assertDatabaseEmpty('comment_reactions');

    post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'dislike']))
        ->assertOk();

    assertDatabaseCount('comment_reactions', 1);

    post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'dislike']))
        ->assertOk();

    assertDatabaseEmpty('comment_reactions');

});

it('returns correct like count', function () {

    $user = User::factory()->create();
    actingAs($user);

    $post = Post::factory()->create();

    $comment = $post->commentAsUser($user, 'This is a Test comment');

    Post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'like']))
        ->assertOk();

    expect($comment->fresh()->likeCount())->toBe(1);
});

it('returns correct dislike count', function () {

    $user = User::factory()->create();
    actingAs($user);

    $post = Post::factory()->create();

    $comment = $post->commentAsUser($user, 'This is a Test comment');

    Post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'dislike']))
        ->assertOk();

    expect($comment->fresh()->dislikeCount())->toBe(1);
});

it('removes reactions when a comment is deleted', function () {

    $user = User::factory()->create();
    actingAs($user);

    $post = Post::factory()->create();

    assertDatabaseEmpty('comments');
    assertDatabaseEmpty('comment_reactions');

    $comment = $post->commentAsUser($user, 'This is a Test comment');

    assertDatabaseCount('comments', 1);

    post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'like']))
        ->assertOk();

    expect($comment->likeCount())->toBe(1);

    $comment->deleteComment($user, $comment->id);

    assertDatabaseEmpty('comments');
    expect($comment->likeCount())->toBe(1);
});

it('redirects unauthorized users when reacting to a comment', function () {

    Route::get('/login', fn () => 'login')->name('login');

    $user = User::factory()->create();
    $post = Post::factory()->create();

    $comment = $post->commentAsUser($user, 'This is a Test comment');

    post(route('comment.reaction.toggle', ['comment' => $comment->id, 'type' => 'dislike']))
        ->assertRedirect(route('login'));

});
