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
        return (Auth::check());
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
                'max:50',
                Rule::unique('events', 'name')->where('date_start', $this->request->get('date_start'))
            ],
            'date_start' => [
                'required',
                Rule::date()->format('Y-m-d\TH:i'),
                Rule::date()->after($date->format('Y-m-d\TH:i')),
                Rule::date()->before($date->modify('+5 years')->format('Y-m-d\TH:i'))
            ],
            'date_end' => [
                'nullable',
                'after:date_start',
                Rule::date()->format('Y-m-d\TH:i'),
                Rule::date()->before($date->modify('+5 years')->format('Y-m-d\TH:i'))
            ],
            'city' => [
                'required',
                'max:50',
            ],
            'location' => [
                'required',
                'max:50',
            ],
            'type' => [
                'nullable',
                'array',
                'max:3',
            ],
            'type.*' => [
                'numeric',
                'distinct'
            ],
            'description' => [
                'nullable',
                'max:5000',
            ],
            'image' => [
                'nullable',
                'image',
                'max:1024',
            ],
            'is_public' => [
                'required',
                'boolean'
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'type' => json_decode($this->type),
        ]);
    }
    
    public function messages()
    {
        return [
            'name.unique' => 'An event with the same name and the same starting date has already been created.'
        ];
    }
}
