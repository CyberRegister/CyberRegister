<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class CyberExpertiseUpdateRequest
 *
 * @package App\Http\Requests
 */
class CyberExpertiseUpdateRequest extends FormRequest
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
            'expertise_code'  => 'required|alpha_num|max:3',
            'description'     => 'required|string',
            'required_points' => 'numeric|min:0',
        ];
    }
}
