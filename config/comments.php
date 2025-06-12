<?php

// config for Nika/LaravelComments
return [

    /*
    * The class used for managing the creation and access
    * of comment entries.
    */
    'comment_class' => \Nika\LaravelComments\Models\Comment::class,

    /*
     * Enables like/dislike functionality on comments.
     */
    'like_dislike_feature' => false,

    /*
     * Controls whether deleting a comment also deletes its replies.
     */
    'delete_replies_on_comment_deletion' => false,
];
