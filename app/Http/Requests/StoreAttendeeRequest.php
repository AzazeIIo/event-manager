<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class StoreAttendeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (Auth::check() && Auth::user()->id == $this->request->get('user_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('attendees', 'user_id')->where('event_id', $this->request->get('event_id'))
            ],
            'event_id' => [
                'required',
                'exists:events,id',
            ]
        ];
    }

    public function messages()
    {
        return [
            'user_id.unique' => 'You have already joined this event.'
        ];
    }
}
