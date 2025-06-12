<?php

namespace App\Services;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CrudService
{
    private string $model;
    private string $resource;

    public function __construct(string $model, string $resource)
    {
        $this->model = $model;
        $this->resource = $resource;
    }

    public function index(): JsonResource
    {
        return $this->model::paginate()->toResourceCollection();
    }

    public function show($id): JsonResource
    {
        return new $this->resource($this->model::find($id));
    }

    public function store(array $data, Request $request): bool
    {
        $model = new $this->model();
        $model->fill($data);
        foreach ($request->allFiles() as $key => $file) {
            $this->updateFile($model, $key, $file);
        }
        return $model->save();
    }

    public function update(int $id, Request $request): bool
    {
        $model = $this->model::find($id);
        $model->fill($request->all());
        foreach ($request->allFiles() as $key => $file) {
            $this->updateFile($model, $key, $file);
        }
        return $model->save();
    }

    public function updateFile(Model &$model, string $key, UploadedFile $file): void
    {
        $upload = Storage::disk('public')->putFile("files", $file);
        $model->$key = '/storage/'.$upload;
    }

    public function destroy(int $id): bool
    {
        $model = $this->model::find($id);
        return $model->delete();
    }

    public static function deleteFile($model, $key)
    {
        if ($model->getOriginal($key) !== $model->image) {
            $fileName = explode('/', $model->getOriginal($key));
            $fileName = end($fileName);
            Storage::disk('public')->delete('files/'.$fileName);
        }
    }
}
