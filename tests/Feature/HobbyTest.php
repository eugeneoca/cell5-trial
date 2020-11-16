<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HobbyTest extends TestCase
{
    use RefreshDatabase;
    public function testHobbyAvailability()
    {
        $response = $this->get('api/hobby');

        $response->assertStatus(200);
    }

    public function testHobbyCreation()
    {
        $response = $this->withHeaders([
            'Accept'=>'application/json',
        ])->json('POST', 'api/hobby', [
            'name' => 'Calculus'
        ]);

        $response->assertStatus(201)->assertJson([
            'name'=>'Calculus'
        ]);

        $this->assertDatabaseHas('hobbies',
            ['name'=>'Calculus']
        );
    }

    public function testHobbyListing()
    {
        \App\Models\Hobby::factory(10)->create();
        $response = $this->withHeaders([
            'Accept'=>'application/json'
        ])->json('GET', 'api/hobby');

        $response->assertStatus(200)->assertJsonCount(10);
    }
}
