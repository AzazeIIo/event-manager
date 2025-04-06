<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Event;
use App\Models\Invitation;
use Auth;

class ShowEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $event = Route::current()->parameters['event'];
        if($event['is_public'] || $event['owner_id'] == Auth::user()->id) {
            return true;
        }
        $invitedTo = Event::whereIn('id', Invitation::where('user_id', '=', Auth::user()->id)->select('event_id'))->pluck('id')->toArray();
        return in_array($event['id'], $invitedTo);
    }

    public function rules(): array
    {
        return [
            'card' => [
                'sometimes',
                'boolean',
            ]
        ];
    }
}
