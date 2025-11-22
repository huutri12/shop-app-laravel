<?php

namespace Database\Factories;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        return [
            'title'       => $title,
            'slug'        => Str::slug($title),
            'author'      => $this->faker->name(),
            'image'       => 'test.jpg',
            'description' => $this->faker->sentence(10),
            'content'     => $this->faker->paragraph(),
        ];
    }
}
