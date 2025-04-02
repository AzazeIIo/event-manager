<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use App\Models\Event;
use App\Models\Invitation;

class DestroyInvitationRequest extends FormRequest
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
        return [
            'is_attendee' => [
                'required',
                'boolean'
            ],
            'userPage' => [
                'required',
                'numeric'
            ]
        ];
    }
}
