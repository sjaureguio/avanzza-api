<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function test_login_user()
    {
        // $this->withoutExceptionHandling;

        $response = $this->post('/api/v1/login', [
            'email' => "admin@gmail.com",
            'password' => "123456",
        ]);

        $response->assertJsonStructure([
            'data' => [
                'token',
            ]
        ])
        ->assertStatus(200);
    }
}
