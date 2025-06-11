<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Genre::factory(3)->create();
        Movie::factory(10)->create();

        $list = Movie::all();
        $genres = Genre::all();
        foreach ($list as $movie) {
            $movie->genres()->attach($genres[rand(0, count($genres) - 1)]);
        }
    }
}
