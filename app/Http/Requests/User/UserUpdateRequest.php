<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'      =>  ['string', 'min:8', 'max:20'],
            'password'  =>  ['string', 'min:8'],
            'thumbnail' =>  ['string', 'max:255'],
            'role'      =>  ['exists:roles,name']
        ];
    }
}
