<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class EventTest extends TestCase
{
    use DatabaseTransactions;

    private static $testData = [
        "name" => 'testname',
        "date_start" => '2026-01-01T12:00',
        "city" => "testcity",
        "location" => 'testlocation',
        'is_public' => true,
    ];

    public function test_guest_is_unauthorized_to_create_new_event(): void
    {
        $user = User::factory()->create();

        $response = $this->call('POST', 'events', ['_token' => csrf_token(), ...EventTest::$testData, 'owner_id' => $user['id']]);

        $response->assertForbidden();
    }

    public function test_user_is_authorized_to_create_new_competition(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->call('POST', 'events', ['_token' => csrf_token(), ...EventTest::$testData, 'owner_id' => $user['id']]);

        $response->assertOk();
    }
}
