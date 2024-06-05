<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'osamaamr397@gmial.com',
            'password' => '123456789'
        ]);
    }
    public function test_login()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'osamaamr397@gmial.com',
            'password' => '123456789'
        ]);
    }
    public function test_logout()
    {
        $response = $this->postJson('/api/logout');
    }
    public function test_posts()
    {
        $response = $this->get('/api/posts');
    }
    public function test_categories()
    {
        $response = $this->get('/api/categories');
    }
    public function test_posts_by_category()
    {
        $response = $this->get('/api/categories/1/posts');
    }
    public function test_create_post()
    {
        $response = $this->postJson('/api/posts', [
            'title' => 'Post Title',
            'content' => 'Post Content',
            'category_id' => 1
        ]);
    }
    public function test_update_post()
    {
        $response = $this->putJson('/api/posts/1', [
            'title' => 'Post Title',
            'content' => 'Post Content',
            'category_id' => 1
        ]);
    }
    public function test_delete_post()
    {
        $response = $this->delete('/api/posts/1');
    }
    public function test_get_post()
    {
        $response = $this->get('/api/posts/1');
    }
    public function test_get_category()
    {
        $response = $this->get('/api/categories/1');
    }
    public function test_create_category()
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'Category Name'
        ]);
    }
    public function test_update_category()
    {
        $response = $this->putJson('/api/categories/1', [
            'name' => 'Category Name'
        ]);
    }
    public function test_delete_category()
    {
        $response = $this->delete('/api/categories/1');
    }
    public function test_get_posts_by_user()
    {
        $response = $this->get('/api/users/1/posts');
    }
    

}
