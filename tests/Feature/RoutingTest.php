<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RoutingTest extends TestCase
{
    use DatabaseTransactions;

    public function test_root_route_redirects_to_events_route(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('events');
    }

    public function test_user_routes_redirect_guest_to_login_route(): void
    {
        $response = $this->get('/privateevents');
        $response->assertRedirect('login');

        $response = $this->get('/myevents');
        $response->assertRedirect('login');
        
        $response = $this->get('/joinedevents');
        $response->assertRedirect('login');
        
        $response = $this->get('/dashboard');
        $response->assertRedirect('login');
    }

    public function test_user_can_access_user_routes(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/privateevents');
        $response->assertStatus(200);

        $response = $this->actingAs($user)
            ->get('/myevents');
        $response->assertStatus(200);
        
        $response = $this->actingAs($user)
            ->get('/joinedevents');
        $response->assertStatus(200);
        
        $response = $this->actingAs($user)
            ->get('/dashboard');
        $response->assertStatus(200);
    }
}
