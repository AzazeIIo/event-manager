<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Attendee;
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

        Invitation::factory(100)->create();

        Attendee::factory(100)->create();
    }
}
