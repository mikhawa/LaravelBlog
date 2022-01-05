<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // on autorise
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // on met nos règles
        return [
            'name' => 'required|min:5|max:255',
            'email' => 'required|min:5|max:255|email',
        ];
    }

    /**
     * Get the validation errors messages
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Le champs name est requis',
            'email.required' => 'Le mail est requis',
            'email.email' => 'Le mail n\'est pas valide',
            'email.min' => 'Le champs doit faire au moins 5 caractères',
        ];
    }
}
