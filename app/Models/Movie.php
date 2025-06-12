<?php

namespace App\Models;

use App\Services\CrudService;
use App\Trait\StatusBits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id Номер
 * @property int $status Статусы
 * @property string $image Ссылка на картинку
 * @property string $name Название
 */
class Movie extends Model
{
    use HasFactory, StatusBits;

    protected $fillable = ['name', 'image', 'genres'];
    protected $appends = ['status_active'];
    protected $attributes = [
        'image' => 'https://via.placeholder.com/640x480.png/000055?text=default'
    ];
    protected $with = ['genres'];

    private $genresData = null;

    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            if ($model->genresData) {
                $model->genres()->sync($model->genresData);
            }
        });
        static::updated(function ($model) {
            CrudService::deleteFile($model, 'image');
        });
    }

    /** RELATIONS */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'rel_genre_movie', 'movie_id', 'genre_id');
    }
    /** RELATIONS */

    /** MUTATIONS */
    public function getStatusActiveAttribute()
    {
        return $this->getBit(0);
    }
    public function setStatusActiveAttribute($value)
    {
        $this->setBit(0, $value);
    }

    public function setGenresAttribute($value)
    {
        if ($this->exists) {
            $this->genres()->sync($value);
        } else {
            $this->genresData = $value;
        }
    }
    /** END MUTATIONS */
}
