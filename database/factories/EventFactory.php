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
            'date_start' => $dateStart->format('Y-m-d\TH:i'),
            'date_end' => $dateEnd->format('Y-m-d\TH:i'),
            'description' => implode(fake()->paragraphs()),
            'city' => fake()->city(),
            'location' => fake()->streetAddress(),
            'image' => fake()->randomElement($images),
            'owner_id' => $user,
            'is_public' => fake()->boolean()
        ];
    }

    public function noImage(): static
    {
        return $this->state(fn (array $attributes) => [
            'image' => null,
        ]);
    }
    
    public function public(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
        ]);
    }
    
    public function private(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => false,
        ]);
    }
}
