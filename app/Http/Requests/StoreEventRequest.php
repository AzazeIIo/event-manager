<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (Auth::check() && Auth::user()->id == $this->request->get('owner_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('events', 'name')->where('date_start', $this->request->get('date_start'))
            ],
            'date_start' => [
                'required',
                'after:now',
                Rule::date()->format('Y-m-d\TH:i')
            ],
            'date_end' => [
                'nullable',
                'after:date_start',
                Rule::date()->format('Y-m-d\TH:i')
            ],
            'city' => [
                'required',
                'max:255',
            ],
            'location' => [
                'required',
                'max:255',
            ],
            'type' => [
                'nullable',
                'array',
                'size:3',
                'max:255',
            ],
            'description' => [
                'nullable',
                'max:255',
            ],
            'image' => [
                'nullable',
                'image',
                'max:255',
            ],
            'is_public' => [
                'required',
                'boolean'
            ]
        ];
    }
}
