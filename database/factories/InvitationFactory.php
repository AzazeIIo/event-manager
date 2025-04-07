<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;
use DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invitations>
 */
class InvitationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userCount = User::count();
        $everyoneInvited = Invitation::select(DB::raw('count(*) as count, event_id'))->groupBy('event_id')->havingRaw('count =' . $userCount-1)->pluck('event_id');
        $availableEvents = Event::where('is_public', '=', false)->whereNotIn('id', $everyoneInvited)->pluck('id');
        $eventId = fake()->randomElement($availableEvents);
        $invitedUsers = Invitation::where('event_id', '=', $eventId)->pluck('user_id');
        $uninvitedUsers = User::whereNotIn('id', $invitedUsers)->get();

        return [
            'event_id' => $eventId,
            'user_id' => fake()->randomElement($uninvitedUsers),
        ];
    }
}
