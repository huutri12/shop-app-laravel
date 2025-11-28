<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BlogApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_blogs(): void
    {
        Blog::factory()->count(3)->create();

        $response = $this->getJson('/api/blogs');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_create_blog(): void
    {
        $data = [
            'title' => 'Test Blog',
            'slug' => 'Mô tả slug',
            'author' => 'Mô tả author',
            'description' => 'Mô tả test',
            'content' => 'Nội dung test',
            'image' => 'test.jpg',
        ];

        $response = $this->postJson('/api/blogs', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('blog', [
            'title' => 'Test Blog',
        ]);
    }
}
