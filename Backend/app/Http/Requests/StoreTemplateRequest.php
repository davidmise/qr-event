<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'identifier' => 'required|string',
            'template' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'overlays' => 'required|array',
            'overlays.*.x' => 'required|integer',
            'overlays.*.y' => 'required|integer',
            'overlays.*.font_size' => 'required|integer',
            'overlays.*.font_family' => 'required|string',
            'overlays.*.font_color' => 'required|string',
        ];
    }
}


