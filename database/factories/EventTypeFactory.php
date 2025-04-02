<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Type;
use App\Models\Event;
use App\Models\EventType;
use DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event_type>
 */
class EventTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $noTypes = Event::whereNotIn('id', EventType::pluck('event_id'))->pluck('id');
        $lessThan3Types = EventType::select(DB::raw('count(*) as count, event_id'))->groupBy('event_id')->havingRaw('count < 3')->pluck('event_id');
        $availableEvents = $noTypes->merge($lessThan3Types);
        
        $randomEvent = fake()->randomElement($availableEvents);
        
        $types = EventType::where('event_id', '=', $randomEvent)->pluck('type_id');
        $availableTypes = Type::whereNotIn('id', $types)->pluck('id');

        $randomType = fake()->randomElement($availableTypes);

        return [
            'event_id' => $randomEvent,
            'type_id' => $randomType
        ];
    }
}
