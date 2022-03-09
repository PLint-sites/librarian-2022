<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveBookAndWriterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'writer' => 'required|min:3|max:255',
            'title' => 'required|min:3|max:255',
            'owned' => 'required|min:0|max:1',
            'completed' => 'required|min:0|max:1',
            'genre_id' => 'required|min:1',
        ];
    }
}
