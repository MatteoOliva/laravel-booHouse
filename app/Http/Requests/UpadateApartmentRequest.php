<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpadateApartmentRequest extends FormRequest
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

            // title
            'title.required' => 'Il titolo è obbligatiorio',
            'title.string' => 'Il titolo deve essere un testo',
            'title.max' => 'Il titolo deve essere max di 100 caratteri',
            // description
            'description.required' => 'La descrizione è obbligatoria',
            // rooms
            'rooms.required' => 'La camera è obbligatoria',
            'rooms.integer' => 'Inserisci un numero',
            'rooms.between' =>  'Il numero delle camere deve essere tra 1 e 500',
            // beds
            'beds.required' => 'Il letto è obbligatorio',
            'beds.integer' => 'Inserisci un numero',
            'beds.between' =>  'Il numero dei letti deve essere tra 1 e 500',
            // toilets
            'toilets.required' => 'Il bagno è obbligatorio',
            'toilets.integer' => 'Inserisci un numero',
            'toilets.between' =>  'Il numero dei bagni deve essere tra 1 e 500',
            // mq
            'mq.required' => 'I metri quadri sono obbligatori',
            'mq.numeric' => 'Inserisci un numero',
            'mq.min' =>  'Il valore inserito deve essere minimo 5',
            // image
            'image.required' => 'Immagine obbligatoria',
            'image.image' => 'Scegliere una immagine',
            'image.mimes' => 'Scegliere un file tra i seguenti tipi :mimes',

            // address
            'address.required' => 'Indirizzo obbligatorio',

            // services
            'services.exists' => 'Servizio non disponibile',

            // 'title.required' => 'The title is required'
            // 'required' => 'Questo campo è obbligatorio',
            // 'string' => 'Questo campo deve essere una stringa',
            // 'max' => 'Inserire un valore inferiore a :max caratteri',
            // 'min' => 'Il valore inserito deve essere minimo :min',
            // 'between' => 'Inserire un numeor tra :min - :max.',
            // 'image' => 'Scegliere un immagine',
            // 'mimes' => 'Scegliere un file compreso tra i seguenti tipi :mimes'
        ];
    }
}
