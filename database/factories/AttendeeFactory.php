<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Attendee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendees>
 */
class AttendeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::pluck('id');
        $randomUser = fake()->randomElement($users);

        $attending = Attendee::where('user_id', '=', $randomUser)->pluck('event_id');
        $invitedTo = Invitation::where('user_id', '=', $randomUser)->whereNotIn('event_id', $attending)->pluck('event_id');
        $publicEvents = Event::where('is_public', '=', true)->whereNotIn('id', $attending)->pluck('id');
        $availableEvents = $invitedTo->merge($publicEvents);

        return [
            'event_id' => fake()->randomElement($availableEvents),
            'user_id' => $randomUser,
        ];
    }
}
