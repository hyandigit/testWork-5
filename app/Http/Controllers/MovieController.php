<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieActiveRequest;
use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Services\CrudService;

class MovieController extends CrudController
{
    public function __construct()
    {
        $this->service = new CrudService(Movie::class, MovieResource::class);
    }

    /**
     * Показываем форму для создания нового ресурса.
     */
    public function create()
    {
        //
    }

    public function store(MovieStoreRequest $request): bool
    {
        return $this->service->store($request->all(), $request);
    }

    /**
     * Показываем форму для редактирования указанного ресурса.
     */
    public function edit(Movie $product)
    {
        //
    }

    public function update(MovieUpdateRequest $request, int $id): bool
    {
        return $this->service->update($id, $request);
    }

    public function active(MovieActiveRequest $request, Movie $movie)
    {
        $movie->status_active = $request->status_active;
        $movie->save();
    }
}
