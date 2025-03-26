<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class UpdateEventRequest extends FormRequest
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
        date_default_timezone_set('Europe/Budapest');
        $date = new \DateTimeImmutable();

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('events', 'name')->ignore(request()->route('event.id'))->where('date_start', $this->request->get('date_start'))
            ],
            'date_start' => [
                'required',
                Rule::date()->format('Y-m-d\TH:i'),
                Rule::date()->after($date->format('Y-m-d\TH:i')),
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
                'max:3',
            ],
            'description' => [
                'nullable',
                'max:5000',
            ],
            'is_public' => [
                'required',
                'boolean'
            ],
            'owner_id' => [
                'required',
                'integer',
            ]
        ];
    }
    
    public function messages()
    {
        return [
            'name.unique' => 'An event with the same name and the same starting date has already been created.'
        ];
    }
}
