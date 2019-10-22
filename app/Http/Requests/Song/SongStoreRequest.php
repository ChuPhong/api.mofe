<?php

namespace App\Http\Requests\Song;

use Illuminate\Foundation\Http\FormRequest;

class SongStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100', 'unique:songs'],
            'other_name' => ['string', 'min:2', 'max:100'],
            'thumbnail' => ['required', 'string', 'max:255', 'unique:songs'],
            'url' => ['required', 'string', 'max:255', 'unique:songs'],
            'year' => ['required', 'integer'],
            'views' => ['integer']
        ];
    }
}
