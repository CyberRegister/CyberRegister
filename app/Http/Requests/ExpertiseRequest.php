<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class ExpertiseRequest
 *
 * @package App\Http\Requests
 */
class ExpertiseRequest extends FormRequest
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
            'certification_code'    => 'required|string|max:15',
            'date_of_certification' => 'required|date',
            'date_of_expiration'    => 'required|date|after:today',
            'user_id'               => 'exists:users,id',
            'cyber_expertise_id'    => 'exists:cyber_expertises,id',
        ];
    }
}
