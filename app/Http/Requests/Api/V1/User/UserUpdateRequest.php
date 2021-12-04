<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !!$this->user()?->can('update', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                  => 'nullable|string',
            'password'              => 'nullable|string|min:6|confirmed',
            'password_confirmation' => 'required_with:password|string|min:6',
            'email' => [
                'nullable', 'string', 'email',
                Rule::unique('users')->ignore($this->route('user'))
            ],
        ];
    }
}
