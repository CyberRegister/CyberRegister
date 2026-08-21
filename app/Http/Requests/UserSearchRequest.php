<?php

namespace App\Http\Requests;

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UserSearchRequest.
 */
class UserSearchRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'q'         => 'required|string|max:255',
            'sort'      => ['nullable', Rule::in(array_keys(UserController::SORTS))],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ];
    }
}
