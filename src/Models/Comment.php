<?php

namespace Nika\LaravelComments\Models;

use Illuminate\Database\Eloquent\Model;
use Nika\LaravelComments\Traits\HasComments;

class Comment extends Model
{
    use HasComments;

    protected $fillable = [
        'user_id',
        'comment'
    ];

}
