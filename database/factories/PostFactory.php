<?php

namespace Nika\LaravelComments\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Nika\LaravelComments\Tests\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
        ];
    }
}
