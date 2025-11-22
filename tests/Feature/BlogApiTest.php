<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BlogApiTest extends TestCase
{
    use RefreshDatabase;   // mỗi test chạy xong sẽ migrate lại DB test

    /** @test */
    public function get_all_blogs(): void
    {
        // 1. Arrange – Chuẩn bị dữ liệu
        Blog::factory()->count(3)->create();

        // 2. Act – Gọi API
        $response = $this->getJson('/api/blogs');

        // 3. Assert – Kiểm tra
        $response->assertStatus(200)
            ->assertJsonCount(3); 
        
    }

    /** @test */
    public function create_blog(): void
    {
        // Giả storage để không ghi file thật
        Storage::fake('public');

        $data = [
            'title'       => 'Test Blog',
            'slug'        => 'test-blog',
            'author'      => 'Test Author',
            'description' => 'Mô tả test',
            'content'     => 'Nội dung test',
            // field image là file thật giả lập
            'image'       => UploadedFile::fake()->image('test.jpg'),
        ];

        // Gửi request POST (multipart)
        $response = $this->postJson('/api/blogs', $data);

        // Kiểm tra API trả status 201 CREATED
        $response->assertStatus(201);

        // Kiểm tra DB test có record vừa insert
        $this->assertDatabaseHas('blog', [
            'title' => 'Test Blog',
            'slug'  => 'test-blog',
        ]);
    }
}
