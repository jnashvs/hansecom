<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    const REQUIRED_INT = 'required|integer|min:1';
    const NON_REQUIRED_INT = 'nullable|integer|min:1';
    const REQUIRED_STRING = 'required|min:1';
    const NON_REQUIRED_STRIGN = 'nullable|min:1|max:255';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
