<?php

// config for Nika/LaravelComments
return [

    /*
    |--------------------------------------------------------------------------
    | Comment Model Class
    |--------------------------------------------------------------------------
    |
    | This class is used to represent and interact with comment records.
    | You can override this if you have your own implementation of the comment model.
    |
    */

    'comment_class' => \Nika\LaravelComments\Models\Comment::class,

    /*
    |--------------------------------------------------------------------------
    | Like/Dislike Feature
    |--------------------------------------------------------------------------
    |
    | When enabled, users will be able to like or dislike comments.
    |
    */

    'like_dislike_feature' => false,

    /*
    |--------------------------------------------------------------------------
    | Delete Comments with Parent Model
    |--------------------------------------------------------------------------
    |
    | When enabled, comments attached to a model (via HasComments trait)
    | will be automatically deleted when the parent model is deleted.
    | Set to false if you want to retain comments after the parent is removed.
    |
    */

    'delete_with_parent' => true,

    /*
    |--------------------------------------------------------------------------
    | Delete Replies with Comment
    |--------------------------------------------------------------------------
    |
    | When enabled, deleting a comment will also delete its replies.
    |
    */

    'delete_replies_on_comment_deletion' => false,

];
