<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Attendee;
use DB;

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
        $invitationCountArray = Invitation::select(DB::raw('count(*) as count, user_id'))->groupBy('user_id')->pluck('count', 'user_id')->toArray();
        $attendingCountArray = Attendee::select(DB::raw('count(*) as count, user_id'))->groupBy('user_id')->pluck('count', 'user_id')->toArray();

        $attendingEverything = array();
        foreach ($users as $user) {
            $totalAvailable = Event::where('is_public', '=', true)->where('owner_id', '!=', $user)->count();
            
            if(in_array($user, array_keys($invitationCountArray))) {
                $totalAvailable += $invitationCountArray[$user];
            }
            if(in_array($user, array_keys($attendingCountArray)) && $totalAvailable == $attendingCountArray[$user]) {
                array_push($attendingEverything, $user);
            }
        }

        $availableUsers = User::whereNotIn('id', $attendingEverything)->pluck('id');
        $randomUser = fake()->randomElement($availableUsers);

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
