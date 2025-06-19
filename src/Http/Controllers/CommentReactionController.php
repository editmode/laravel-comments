<?php

namespace Nika\LaravelComments\Http\Controllers;

use Illuminate\Http\Request;

class CommentReactionController
{
    public function toggle(Request $request, int $id, string $type)
    {
        abort_unless(
            config('comments.like_dislike_feature'),
            403,
            __('This feature is disabled')
        );

        $user = $request->user();

        $commentClass = config('comments.comment_class');

        $comment = $commentClass::findOrFail($id);

        $reaction = $comment
            ->reactions()
            ->where('user_id', $user->id)
            ->first();

        if ($reaction !== null && $reaction->type === $type) {
            $reaction->delete();
        } else {
            $comment->reactions()->updateOrCreate(
                ['user_id' => $user->id],
                ['type' => $type]
            );
        }

    }
}
