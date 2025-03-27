<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Auth;
use App\Models\Event;

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
        if(Event::select('owner_id')->where('id', '=', $this->request->get('event_id'))->get()[0]['owner_id'] == Auth::user()->id) {
            throw ValidationException::withMessages(['event_id' => "You can't join your own event."]);
        }

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
