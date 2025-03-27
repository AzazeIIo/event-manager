<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Attendee;

class DestroyAttendeeRequest extends FormRequest
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
        if(count(Attendee::where('user_id', '=', $this->request->get('user_id'))->where('event_id', '=', $this->request->get('event_id'))->get()) == 0) {
            throw ValidationException::withMessages(['event_id' => 'You have already left this event.']);
        }

        return [
            'user_id' => [
                'required',
                'exists:users,id',
            ],
            'event_id' => [
                'required',
                'exists:events,id',
            ]
        ];
    }
}
