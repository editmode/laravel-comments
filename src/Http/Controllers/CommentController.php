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
}
