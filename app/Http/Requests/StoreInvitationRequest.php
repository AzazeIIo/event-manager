<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Auth;
use App\Models\Event;

class StoreInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return (Auth::check() && Auth::user()->id == Event::where('id', '=', $this->route('event.id'))->pluck('owner_id')[0]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if(Event::find($this->route('event.id'))['is_public']) {
            throw ValidationException::withMessages(['event_id' => 'Public events are visible to everyone.']);
        }

        return [
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('invitations', 'user_id')->where('event_id', $this->route('event.id'))
            ]
        ];
    }

    public function messages()
    {
        return [
            'user_id.unique' => 'This user is already invited.'
        ];
    }
}
