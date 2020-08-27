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

        $user = factory(User::class)->create(['verified' => true]);
        // Authenticated and verified user is allowed to see the homepage.
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);
    }

    // TODO: there could be more tests
    public function testVerify()
    {
        $user = factory(User::class)->create(['verified' => false]);
        $response = $this->actingAs($user)->get('/user');
        $response->assertStatus(302);
        $this->assertTrue(true);
    }
}
