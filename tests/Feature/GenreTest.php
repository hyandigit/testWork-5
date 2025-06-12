<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_crud_index(): void
    {
        $this->assertDatabaseCount('genres', 3);

        $response = $this->get('/api/genre/');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [['id', 'name']],
            'links' => [],
            'meta' => []
        ]);
    }

    public function test_crud_store(): void
    {
        $response = $this->post('/api/genre', ['name' => 'Genre']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('genres', ['name' => 'Genre']);
    }

    public function test_crud_update(): void
    {
        $this->test_crud_store();
        $this->assertDatabaseCount('genres', 4);
        $response = $this->putJson('/api/genre/4', ['name' => 'Genre 1']);
        $response->assertStatus(200);
        $this->assertDatabaseHas('genres', ['id' => 4, 'name' => 'Genre 1']);
    }

    public function test_crud_destroy(): void
    {
        $this->test_crud_store();
        $this->assertDatabaseCount('genres', 4);
        $response = $this->delete('/api/genre/4');
        $response->assertStatus(200);
        $this->assertDatabaseCount('genres', 3);
    }
}
