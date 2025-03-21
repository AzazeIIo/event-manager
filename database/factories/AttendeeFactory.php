<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;

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
        $publicEvents = Event::where('is_public', '=', true)->pluck('id');
        $users = User::pluck('id');

        return [
            'event_id' => fake()->randomElement($publicEvents),
            'user_id' => fake()->randomElement($users),
        ];
    }
}
