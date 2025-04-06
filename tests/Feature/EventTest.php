<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;

class EventTest extends TestCase
{
    use DatabaseTransactions;

    private static $testData = [
        "name" => 'testname',
        "date_start" => '2026-01-01T12:00',
        "date_end" => '2026-01-02T12:00',
        "city" => "testcity",
        "location" => 'testlocation',
        'is_public' => true,
    ];

    private static $testEditData = [
        "name" => 'editedname',
        "date_start" => '2026-01-01T12:00',
        "date_end" => '2026-01-02T12:00',
        "city" => "testcity",
        "location" => 'testlocation',
        "description" => 'testdescription',
        'is_public' => true,
    ];

    public function test_guest_is_unauthorized_to_create_new_event(): void
    {
        $user = User::factory()->create();

        $response = $this->call('POST', 'events', ['_token' => csrf_token(), ...EventTest::$testData]);

        $response->assertForbidden();
    }

    public function test_user_is_authorized_to_create_new_event(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->call('POST', 'events', ['_token' => csrf_token(), ...EventTest::$testData]);

        $response->assertOk();
    }

    public function test_new_event_can_be_created_once(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->call('POST', 'events', ['_token' => csrf_token(), ...EventTest::$testData]);

        $this->assertDatabaseHas('events', EventTest::$testData);

        $response = $this->actingAs($user)->call('POST', 'events', ['_token' => csrf_token(), ...EventTest::$testData]);

        $response->assertInvalid();
    }

    public function test_guest_is_unauthorized_to_modify_events(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create();

        $response = $this->call('PUT', 'events/' . $event['id'], ['_token' => csrf_token(), ...EventTest::$testEditData]);

        $response->assertForbidden();
    }

    public function test_user_is_authorized_to_modify_events(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'owner_id' => $user['id']
        ]);

        $response = $this->actingAs($user)->call('PUT', 'events/' . $event['id'], ['_token' => csrf_token(), ...EventTest::$testEditData]);
        $response->assertOK();
    }

    public function test_user_is_unauthorized_to_modify_other_users_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'owner_id' => $user['id']
        ]);
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->call('PUT', 'events/' . $event['id'], ['_token' => csrf_token(), ...EventTest::$testEditData]);
        $response->assertForbidden();
    }

    public function test_event_can_be_modified(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            ...EventTest::$testData,
            'owner_id' => $user['id']
        ]);

        $this->assertDatabaseHas('events', EventTest::$testData);

        $this->actingAs($user)->call('PUT', 'events/' . $event['id'], ['_token' => csrf_token(), ...EventTest::$testEditData]);
        
        $this->assertDatabaseHas('events', EventTest::$testEditData);
        $this->assertDatabaseMissing('events', EventTest::$testData);
    }

    public function test_guest_is_unauthorized_to_delete_events(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create();

        $response = $this->call('DELETE', 'events/' . $event['id'], ['_token' => csrf_token()]);

        $response->assertForbidden();
    }

    public function test_user_is_authorized_to_delete_events(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'owner_id' => $user['id']
        ]);

        $response = $this->actingAs($user)->call('DELETE', 'events/' . $event['id'], ['_token' => csrf_token()]);
        $response->assertOK();
    }

    public function test_user_is_unauthorized_to_delete_other_users_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'owner_id' => $user['id']
        ]);
        $otherUser = User::factory()->create();

        $response = $this->actingAs($otherUser)->call('DELETE', 'events/' . $event['id'], ['_token' => csrf_token()]);
        $response->assertForbidden();
    }

    public function test_event_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            ...EventTest::$testData,
            'owner_id' => $user['id']
        ]);

        $this->assertDatabaseHas('events', EventTest::$testData);

        $this->actingAs($user)->call('DELETE', 'events/' . $event['id'], ['_token' => csrf_token()]);
        
        $this->assertDatabaseMissing('events', EventTest::$testData);
    }

    public function test_everyone_is_authorized_to_view_public_events(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => true,
            'owner_id' => $user['id']
        ]);
        $otherUser = User::factory()->create();

        $response = $this->call('GET', 'events/' . $event['id'], ['_token' => csrf_token()]);
        $response->assertOK();
        $response = $this->actingAs($user)->call('GET', 'events/' . $event['id'], ['_token' => csrf_token()]);
        $response->assertOK();
        $response = $this->actingAs($otherUser)->call('GET', 'events/' . $event['id'], ['_token' => csrf_token()]);
        $response->assertOK();
    }

    public function test_only_owner_and_invited_users_are_authorized_to_view_private_events(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => false,
            'owner_id' => $user['id']
        ]);
        $otherUser = User::factory()->create();
        $invitedUser = User::factory()->create();
        Invitation::factory()->create([
            'event_id' => $event['id'],
            'user_id' => $invitedUser['id']
        ]);

        $response = $this->call('GET', 'events/' . $event['id'], ['_token' => csrf_token()]);
        $response->assertForbidden();
        $response = $this->actingAs($user)->call('GET', 'events/' . $event['id'], ['_token' => csrf_token()]);
        $response->assertOK();
        $response = $this->actingAs($otherUser)->call('GET', 'events/' . $event['id'], ['_token' => csrf_token()]);
        $response->assertForbidden();
        $response = $this->actingAs($invitedUser)->call('GET', 'events/' . $event['id'], ['_token' => csrf_token()]);
        $response->assertOK();
    }

    public function test_events_can_be_searched(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create(EventTest::$testData);
        $otherEvent = Event::factory()->noImage()->create(EventTest::$testEditData);

        $response = $this->call('GET', 'events', ['_token' => csrf_token(), 'name' => 'edited']);
        $response->assertSeeText('editedname');
        $response->assertDontSeeText('testname');

        $response = $this->call('GET', 'events', ['_token' => csrf_token(), 'name' => 'test']);
        $response->assertSeeText('testname');
        $response->assertDontSeeText('editedname');
    }
}
