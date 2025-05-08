<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Feature extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    public function test_user_can_send_duel_request()
    {
        $fromUser = User::factory()->create();
        $toUser = User::factory()->create();

        $this->actingAs($fromUser)
            ->postJson('/api/duels/request', [
                'to_user_id' => $toUser->id,
            ])
            ->assertStatus(200)
            ->assertJson(['message' => 'Duel request sent.']);
    }

}
