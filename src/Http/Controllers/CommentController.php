<?php

namespace Nika\LaravelComments\Http\Controllers;

use Illuminate\Http\Request;

class CommentController
{
    public function destroy(Request $request, int $id)
    {
        $user = $request->user();

        $comment = app(config('comments.comment_class'))->findOrFail($id);

        abort_unless($user->id === $comment->user_id, 403);

        $comment->delete();

    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000'
        ]);

        $user = $request->user();

        abort_if(!$user, 403);

        $comment = app(config('comments.comment_class'))->findOrFail($id);

        abort_unless($user->id === $comment->user_id, 403);

        $comment->update([
            'body' => $validated['body']
        ]);
    }
}
