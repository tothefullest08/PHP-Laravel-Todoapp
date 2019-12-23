<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTodoRequest extends FormRequest
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
            'title'       => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'completed' => 'boolean'
        ];
    }

    /**
     * @return array|void
     */
    public function messages()
    {
        return [
            'title.required' => 'title field is required',
            'title.string' => 'title field must be string',
            'title.min' => 'title field must be 3 character minimum',
            'description.required' => 'title field is required',
            'description.string' => 'title field must be string',
            'description.min' => 'title field must be 3 character minimum',
        ];
    }
}
