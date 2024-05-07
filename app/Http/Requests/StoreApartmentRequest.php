<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'description' => 'required',
            'rooms' => 'required|integer|between:1,500',
            'beds' => 'required|integer|between:1,500',
            'toilets' => 'required|integer|between:1,500',
            'mq' => 'required|numeric|min:5',
            'image' => 'required|image|mimes:jpeg,jpg,png,gif',
            'address' => 'required|string',
            'lat' => 'required',
            'lon' => 'required',
            'services' => 'exists:services,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            // 'title.required' => 'The title is required'
            'required' => 'Questo campo è obbligatorio',
            'string' => 'Questo campo deve essere una stringa',
            'max' => 'Inserire un valore inferiore a :max caratteri',
            'min' => 'Il valore inserito deve essere minimo :min',
            'between' => 'Inserire un numeor tra :min - :max',
            'image' => 'Scegliere un immagine',
            'mimes' => 'Scegliere un file compreso tra i seguenti tipi :mimes'
        ];
    }
}
