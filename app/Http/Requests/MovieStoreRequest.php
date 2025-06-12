<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'genres' => 'array',
            'genres.*' => 'integer|exists:genres,id',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }
}
