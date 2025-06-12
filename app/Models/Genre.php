<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id Номер
 * @property string $name Название
 */
class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /** RELATIONS */
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'rel_genre_movie', 'genre_id', 'movie_id');
    }
    /** END RELATIONS */
}
