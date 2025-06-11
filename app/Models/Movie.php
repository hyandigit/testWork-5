<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    /** RELATIONS */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'rel_genre_movie', 'movie_id', 'genre_id');
    }
    /** RELATIONS */
}
