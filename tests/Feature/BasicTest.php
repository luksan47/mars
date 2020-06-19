<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class BasicTest extends TestCase
{
    /**
     * A basic test.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testBasicAuth()
    {
        // Unauthenticated user is not allowed to see the homepage, redirected to login.
        $response = $this->get('/home');
        $response->assertStatus(302);

        $user = factory(User::class)->create();
        // Authenticated user is allowed to see the homepage.
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);
    }

    public function testVerify()
    {
        // TODO
        $this->assertTrue(true);
    }
}
