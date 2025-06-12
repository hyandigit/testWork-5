<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreStoreRequest;
use App\Http\Requests\GenreUpdateRequest;
use App\Http\Resources\GenreResource;
use App\Models\Genre;
use App\Services\CrudService;
use Illuminate\Http\Resources\Json\JsonResource;

class GenreController extends CrudController
{
    protected $service;

    public function __construct()
    {
        $this->service = new CrudService(Genre::class, GenreResource::class);
    }

    public function show(int $id): JsonResource
    {
        return Genre::find($id)->movies()->paginate()->toResourceCollection();
    }

    /**
     * Показываем форму для создания нового ресурса.
     */
    public function create()
    {
        //
    }

    public function store(GenreStoreRequest $request): bool
    {
        return $this->service->store($request->all());
    }

    /**
     * Показываем форму для редактирования указанного ресурса.
     */
    public function edit(Genre $product)
    {
        //
    }

    public function update(GenreUpdateRequest $request, int $id): bool
    {
        return $this->service->update($id, $request->array());
    }


}
