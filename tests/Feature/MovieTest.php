<?php

namespace Tests\Feature;

use App\Models\Movie;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * A basic feature test example.
     */
    public function test_crud_index(): void
    {
        $this->assertDatabaseCount('movies', 10);

        $response = $this->get('/api/movie/');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [['id', 'name', 'image', 'status_active', 'genres' => [['id', 'name']]]],
            'links' => [],
            'meta' => []
        ]);
    }

    public function test_crud_store(): void
    {
        $response = $this->post('/api/movie', ['name' => 'Movie', 'genres' => [1,3]]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('movies', [
            'id' => 11, 'name' => 'Movie', 'image' => 'https://via.placeholder.com/640x480.png/000055?text=default', 'status' => 0
        ]);
        $this->assertDatabaseHas('rel_genre_movie', ['movie_id' => 11, 'genre_id' => 1]);
        $this->assertDatabaseHas('rel_genre_movie', ['movie_id' => 11, 'genre_id' => 3]);
    }

    public function test_crud_update(): void
    {
        $this->test_crud_store();
        $this->assertDatabaseCount('movies', 11);
        $file = UploadedFile::fake()->image('image.jpg');
        $response = $this->put('/api/movie/11', ['name' => 'Movie 1', 'image' => $file]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('movies', ['id' => 11, 'name' => 'Movie 1']);
        $model = Movie::find(11);
        Storage::disk('public')->assertExists(str_replace('storage/', '', $model->image));
    }

    public function test_crud_destroy(): void
    {
        $this->test_crud_store();
        $this->assertDatabaseCount('movies', 11);
        $this->assertDatabaseCount('movies', 11);
        $response = $this->delete('/api/movie/11');
        $response->assertStatus(200);
        $this->assertDatabaseCount('movies', 10);
    }
}
