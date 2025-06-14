<?php

namespace Nika\LaravelComments\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nika\LaravelComments\Traits\HasComments;

class Post extends Model
{
    use HasComments, HasFactory;
}
