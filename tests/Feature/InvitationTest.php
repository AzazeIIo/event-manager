<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Event;
use App\Models\Invitation;

class InvitationTest extends TestCase
{
    public function test_only_owner_is_authorized_to_invite_once(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => false,
            'owner_id' => $user['id']
        ]);
        $otherUser = User::factory()->create();

        $response = $this->call('POST', 'events/' . $event['id'] . '/invitations', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);
        $response->assertForbidden();

        $response = $this->actingAs($otherUser)->call('POST', 'events/' . $event['id'] . '/invitations', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);
        $response->assertForbidden();
        
        $response = $this->actingAs($user)->call('POST', 'events/' . $event['id'] . '/invitations', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);
        $response->assertOK();
        
        $response = $this->actingAs($user)->call('POST', 'events/' . $event['id'] . '/invitations', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);
        $response->assertInvalid();
    }

    public function test_owner_can_invite_users(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => false,
            'owner_id' => $user['id']
        ]);
        $otherUser = User::factory()->create();
        
        $this->assertDatabaseMissing('invitations', [
            'user_id' => $otherUser['id'],
            'event_id' => $event['id']
        ]);
        $response = $this->actingAs($user)->call('POST', 'events/' . $event['id'] . '/invitations', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);
        $this->assertDatabaseHas('invitations', [
            'user_id' => $otherUser['id'],
            'event_id' => $event['id']
        ]);
    }

    public function test_owner_cant_invite_themselves(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => false,
            'owner_id' => $user['id']
        ]);
        
        $response = $this->actingAs($user)->call('POST', 'events/' . $event['id'] . '/invitations', ['_token' => csrf_token(), 'user_id' => $user['id']]);
        $response->assertInvalid();
    }
    
    public function test_public_events_cant_have_invitations(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->noImage()->create([
            'is_public' => true,
            'owner_id' => $user['id']
        ]);
        $otherUser = User::factory()->create();
        
        $response = $this->actingAs($user)->call('POST', 'events/' . $event['id'] . '/invitations', ['_token' => csrf_token(), 'user_id' => $otherUser['id']]);
        $response->assertInvalid();
    }

    public function test_only_owner_is_authorized_to_uninvite(): void
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

        $response = $this->call('DELETE', 'events/' . $event['id'] . '/invitations/' . $invitation['id'], ['_token' => csrf_token()]);
        $response->assertForbidden();

        $response = $this->actingAs($otherUser)->call('DELETE', 'events/' . $event['id'] . '/invitations/' . $invitation['id'], ['_token' => csrf_token()]);
        $response->assertForbidden();
        
        $response = $this->actingAs($user)->call('DELETE', 'events/' . $event['id'] . '/invitations/' . $invitation['id'], ['_token' => csrf_token(), 'is_attendee' => false, 'userPage' => 1]);
        $response->assertOK();
    }

    public function test_owner_can_uninvite_users(): void
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
        
        $this->assertDatabaseHas('invitations', [
            'user_id' => $otherUser['id'],
            'event_id' => $event['id']
        ]);

        $response = $this->actingAs($user)->call('DELETE', 'events/' . $event['id'] . '/invitations/' . $invitation['id'], ['_token' => csrf_token(), 'is_attendee' => false, 'userPage' => 1]);

        $this->assertDatabaseMissing('invitations', [
            'user_id' => $otherUser['id'],
            'event_id' => $event['id']
        ]);
    }
}
