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
        return (Auth::check() && Auth::user()->id == $this->route('attendee.user_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if(count(Attendee::where('user_id', '=', Auth::user()->id)->where('event_id', '=', $this->route('event.id'))->get()) == 0) {
            throw ValidationException::withMessages(['event_id' => 'You have already left this event.']);
        }
        return [];
    }
}
