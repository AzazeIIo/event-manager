<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\Attendee;

class AttendeeTest extends TestCase
{
    public function test_only_other_users_are_authorized_to_join_public_events_once(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => true,
            'owner_id' => $user['id']
        ]);
        $otherUser = User::factory()->create();

        $response = $this->call('POST', 'events/' . $event['id'] . '/attendees', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);
        $response->assertForbidden();
        
        $response = $this->actingAs($otherUser)->call('POST', 'events/' . $event['id'] . '/attendees', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);
        $response->assertOK();
        
        $response = $this->actingAs($otherUser)->call('POST', 'events/' . $event['id'] . '/attendees', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);
        $response->assertInvalid();
    }

    public function test_owner_cant_join_their_own_event(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => true,
            'owner_id' => $user['id']
        ]);
        
        $response = $this->actingAs($user)->call('POST', 'events/' . $event['id'] . '/attendees', ['_token' => csrf_token(), 'user_id' => $user['id']]);
        $response->assertInvalid();
    }

    public function test_only_invited_users_are_authorized_to_join_private_events_once(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => false,
            'owner_id' => $user['id']
        ]);
        $invitedUser = User::factory()->create();
        $uninvitedUser = User::factory()->create();
        Invitation::factory()->create([
            'event_id' => $event['id'],
            'user_id' => $invitedUser['id']
        ]);

        $response = $this->call('POST', 'events/' . $event['id'] . '/attendees', ['_token' => csrf_token(), 'user_id' => $invitedUser['id']]);
        $response->assertForbidden();
        
        $response = $this->actingAs($uninvitedUser)->call('POST', 'events/' . $event['id'] . '/attendees', ['_token' => csrf_token(), 'user_id' => $uninvitedUser['id']]);
        $response->assertForbidden();

        $response = $this->actingAs($invitedUser)->call('POST', 'events/' . $event['id'] . '/attendees', ['_token' => csrf_token(), 'user_id' => $invitedUser['id']]);
        $response->assertOK();
        
        $response = $this->actingAs($invitedUser)->call('POST', 'events/' . $event['id'] . '/attendees', ['_token' => csrf_token(), 'user_id' => $invitedUser['id']]);
        $response->assertInvalid();
    }

    public function test_users_can_only_join_as_themselves(): void
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

        $response = $this->actingAs($invitedUser)->call('POST', 'events/' . $event['id'] . '/attendees', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);
        $response->assertForbidden();
    }

    public function test_only_attending_user_is_authorized_to_leave(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => false,
            'owner_id' => $user['id']
        ]);
        $otherUser = User::factory()->create();
        $invitation = Invitation::factory()->create([
            'event_id' => $event['id'],
            'user_id' => $otherUser['id']
        ]);
        $attendee = Attendee::factory()->create([
            'event_id' => $event['id'],
            'user_id' => $otherUser['id']
        ]);

        $response = $this->call('DELETE', 'events/' . $event['id'] . '/attendees/' . $attendee['id'], ['_token' => csrf_token()]);
        $response->assertForbidden();

        $response = $this->actingAs($user)->call('DELETE', 'events/' . $event['id'] . '/attendees/' . $attendee['id'], ['_token' => csrf_token()]);
        $response->assertForbidden();
        
        $response = $this->actingAs($otherUser)->call('DELETE', 'events/' . $event['id'] . '/attendees/' . $attendee['id'], ['_token' => csrf_token()]);
        $response->assertOK();
    }

    public function test_user_can_join_and_leave(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => false,
            'owner_id' => $user['id']
        ]);
        $otherUser = User::factory()->create();
        $invitation = Invitation::factory()->create([
            'event_id' => $event['id'],
            'user_id' => $otherUser['id']
        ]);

        $this->assertDatabaseMissing('attendees', [
            'user_id' => $otherUser['id'],
            'event_id' => $event['id']
        ]);

        $response = $this->actingAs($otherUser)->call('POST', 'events/' . $event['id'] . '/attendees', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);

        $this->assertDatabaseHas('invitations', [
            'user_id' => $otherUser['id'],
            'event_id' => $event['id']
        ]);

        $attendee = Attendee::where('user_id', '=', $otherUser['id'])->get()[0];
        $response = $this->actingAs($otherUser)->call('DELETE', 'events/' . $event['id'] . '/attendees/' . $attendee['id'], ['_token' => csrf_token()]);

        $this->assertDatabaseMissing('attendees', [
            'user_id' => $otherUser['id'],
            'event_id' => $event['id']
        ]);
    }
}
