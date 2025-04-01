<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;

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
        $privateEvents = Event::where('is_public', '=', false)->pluck('id');
        $eventId = fake()->randomElement($privateEvents);
        $invitedUsers = Invitation::where('event_id', '=', $eventId)->pluck('user_id');
        $uninvitedUsers = User::whereNotIn('user_id', $invitedUsers)->get();

        return [
            'event_id' => $eventId,
            'user_id' => fake()->randomElement($uninvitedUsers),
        ];
    }
}
