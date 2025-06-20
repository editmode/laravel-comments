<?php

namespace Nika\LaravelComments\Http\Controllers;

use Illuminate\Http\Request;

class CommentController
{
    public function destroy(Request $request, int $id)
    {
        $comment = app(config('comments.comment_class'))->findOrFail($id);

        $this->authorizeCommentAccess($request, $comment);

        $comment->delete();

    }

    private function authorizeCommentAccess(Request $request, $comment): void
    {
        $user = $request->user();
        abort_if(! $user, 403);
        abort_unless($user->id === $comment->user_id, 403);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = app(config('comments.comment_class'))->findOrFail($id);

        $this->authorizeCommentAccess($request, $comment);

        $comment->update([
            'body' => $validated['body'],
        ]);
    }
}
