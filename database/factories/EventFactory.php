<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $dateStart = fake()->unique()->dateTimeBetween('+1 hour', '+1 year');
        $dateEnd = fake()->dateTimeBetween((clone $dateStart)->modify('+1 hour'), (clone $dateStart)->modify('+1 week'));
        $users =  User::pluck('id');
        $user = fake()->randomElement($users);
        $images = ['userImages/testimage.jpg', 'userImages/testimage2.jpg'];

        return [
            'name' => $name,
            'date_start' => $dateStart,
            'date_end' => $dateEnd,
            'description' => implode(fake()->paragraphs()),
            'type' => json_encode([fake()->randomDigitNot(0), fake()->randomDigitNot(0)]),
            'city' => fake()->city(),
            'location' => fake()->streetAddress(),
            'image' => fake()->randomElement($images),
            'owner_id' => $user,
            'is_public' => fake()->boolean()
        ];
    }
}
