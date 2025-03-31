<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Auth;
use App\Models\Event;
use App\Models\Invitation;

class StoreAttendeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (Auth::check() && Auth::user()->id == $this->request->get('user_id') && (Event::find($this->route('event.id'))['is_public'] || count(Invitation::where('user_id', '=', Auth::user()->id)->where('event_id', '=', $this->route('event.id'))->get()) != 0));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if(Event::where('id', '=', $this->route('event.id'))->pluck('owner_id')[0] == Auth::user()->id) {
            throw ValidationException::withMessages(['event_id' => "You can't join your own event."]);
        }

        return [
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('attendees', 'user_id')->where('event_id', $this->route('event.id'))
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
