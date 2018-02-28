<?php

namespace App\Http\Requests;

use App\Rules\ReservedUsernames;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserUpdateRequest
 *
 * @package App\Http\Requests
 */
class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cyber_code' => [
                new ReservedUsernames(),
                'required',
                'alpha_num',
                'max:6',
            ],
            'first_name'     => 'required|string|max:255',
            'middle_name'    => 'max:255',
            'last_name'      => 'required|string|max:255',
            'date_of_birth'  => 'required|date|before:yesterday',
            'place_of_birth' => 'required|string|max:255',
            'email'          => 'required|string|email|max:255',
        ];
    }
}
