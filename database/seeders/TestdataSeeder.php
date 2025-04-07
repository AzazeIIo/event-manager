<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Invitation;
use App\Models\Attendee;

class TestdataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(20)->create();

        Event::factory(25)->private()->create();

        Event::factory(25)->public()->create();

        for($i = 0; $i != 100; $i++) {
            EventType::factory()->create();
        }

        for($i = 0; $i != 200; $i++) {
            Invitation::factory()->create();
        }

        for($i = 0; $i != 200; $i++) {
            Attendee::factory()->create();
        }
    }
}
