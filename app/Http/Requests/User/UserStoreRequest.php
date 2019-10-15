<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Auth\RegisterRequest;

class UserStoreRequest extends RegisterRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'thumbnail' =>  ['string', 'max:255'],
            'role'      =>  ['required', 'exists:roles,name']
        ]);
    }
}
