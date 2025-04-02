<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Attendee;
use App\Models\EventType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TypeSeeder::class);

        User::factory(100)->create();

        Event::factory(100)->create();

        for($i = 0; $i != 200; $i++) {
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
