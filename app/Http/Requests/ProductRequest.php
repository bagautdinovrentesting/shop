<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'description' => 'string',
            'section_id' => 'required|integer|exists:sections,id',
            'status' => 'boolean',
            'properties' => 'array',
            'detail_photo' => 'image|mimes:jpg,jpeg,png',
            'preview_photo' => 'image|mimes:jpg,jpeg,png'
        ];
    }
}
