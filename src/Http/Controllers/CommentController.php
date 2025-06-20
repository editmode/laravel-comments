<?php

namespace Nika\LaravelComments\Http\Controllers;

use Illuminate\Http\Request;

class CommentController
{
    public function destroy(Request $request, int $id)
    {
        $comment = $this->findComment($id);

        $this->authorizeCommentAccess($request, $this->findComment($id));

        $comment->delete();

    }

    private function findComment(int $id)
    {
        return app(config('comments.comment_class'))->findOrFail($id);
    }

    private function authorizeCommentAccess(Request $request, $comment): void
    {
        $user = $request->user();
        abort_if(!$user, 403);
        abort_unless($user->id === $comment->user_id, 403);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        abort_if(!$user, 403);

        $validated = request()->validate([
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string',
            'body' => 'required|string|max:1000',
        ]);

        $modelClass = $validated['commentable_type'];
        $model = $modelClass::findOrFail($validated['commentable_id']);

        $model->commentAsUser($user, $validated['body']);


    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = $this->findComment($id);

        $this->authorizeCommentAccess($request, $comment);

        $comment->update([
            'body' => $validated['body'],
        ]);
    }
}
