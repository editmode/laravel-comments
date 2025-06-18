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
