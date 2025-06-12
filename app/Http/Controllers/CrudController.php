<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Services\CrudService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CrudController extends Controller
{
    protected $service;

    public function index(): JsonResource
    {
        return $this->service->index();
    }

    public function show(int $id): JsonResource
    {
        return $this->service->show($id);
    }

    public function destroy(int $id): bool
    {
        return $this->service->destroy($id);
    }
}
