<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker;
use App\Models\Post;

class PostTest extends TestCase
{

    public function test_get_posts()
    {
        $response = $this->call('GET', '/api/posts');
        $response->isSuccessful();
    }

    public function test_create_post()
    {
        $this->json('POST', '/api/posts',[
            'title' => $this->faker->word(),
            'body' => $this->faker->paragraph()
        ])->seeJson([
            'status' => 'success',
            'Post Created'
         ]);;
    }

    public function test_update_post()
    {
        $post = Post::factory()->create();

        $this->json('PUT', '/api/posts/'. $post->id,[
            'title' => $this->faker->word(),
            'body' => $this->faker->paragraph()
        ])->seeJson([
            'status' => 'success',
            'Post Updated'
         ]);;
    }

    public function test_delete_post()
    {
        $post = Post::factory()->create();

        $this->json('PUT', '/api/posts/'. $post->id . '/delete')
        ->seeJson([
            'status' => 'success',
            'Post Deleted'
         ]);;
    }
}
