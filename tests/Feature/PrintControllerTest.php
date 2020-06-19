<?php

namespace Tests\Feature;

use App\User;
use App\Role;
use App\PrintAccount;
use App\Http\Controllers\PrintController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrintControllerTest extends TestCase
{
    /**
     * Testing a verified user with no printing related permissions.
     */
    public function testUserWithoutPermissions()
    {
        $user = factory(User::class)->create();
        $user->setVerified();
        $this->actingAs($user);

        // The user is not allowed to see the page without the correct permissions.
        // TODO: test this with freshly registered user.
        $response = $this->get('/print');
        $response->assertStatus(403);
        $response = $this->get('/print/free_pages/all');
        $response->assertStatus(403);
        $response = $this->get('/print/print_jobs/all');
        $response->assertStatus(403);
        $response = $this->get('/print/admin');
        $response->assertStatus(403);
        $response = $this->get('/print/account_history');
        $response->assertStatus(403);

        $response = $this->post('/print/modify_balance', []);
        $response->assertStatus(403);
        $response = $this->post('/print/add_free_pages', []);
        $response->assertStatus(403);
        $response = $this->post('/print/transfer_balance', []);
        $response->assertStatus(403);
        $response = $this->post('/print/print_jobs/0/cancel', []);
        $response->assertStatus(403);

        $response = $this->put('/print/print', []);
        $response->assertStatus(403);
    }

    /**
     * Testing a verified user with PRINTER permission.
     */
    public function testUserWithPrinterPermissions()
    {
        $user = factory(User::class)->create();
        $user->setVerified();
        $this->actingAs($user);
        $user->roles()->attach(Role::getId(Role::PRINTER));

        $response = $this->get('/print');
        $response->assertStatus(200);
        $response = $this->get('/print/free_pages/all');
        $response->assertStatus(200);
        $response = $this->get('/print/print_jobs/all');
        $response->assertStatus(200);
        $response = $this->get('/print/admin');
        $response->assertStatus(403);
        $response = $this->get('/print/account_history');
        $response->assertStatus(403);

        $response = $this->post('/print/modify_balance', []);
        $response->assertStatus(403);
        $response = $this->post('/print/add_free_pages', []);
        $response->assertStatus(403);
        $response = $this->post('/print/transfer_balance', []);
        $response->assertStatus(302);
        factory(\App\PrintJob::class)->create(['user_id' => $user->id]);
        $response = $this->post('/print/print_jobs/' . $user->printJobs()->first()->id . '/cancel', []);
        $response->assertStatus(200);

        $response = $this->put('/print/print', []);
        $response->assertStatus(302);
    }

    /**
     * Testing a verified user with PRINT_ADMIN permission.
     */
    public function testUserWithPrintAdminPermissions()
    {
        $user = factory(User::class)->create();
        $user->setVerified();
        $this->actingAs($user);
        $user->roles()->attach(Role::getId(Role::PRINT_ADMIN));

        $response = $this->get('/print');
        $response->assertStatus(200);
        $response = $this->get('/print/free_pages/all');
        $response->assertStatus(200);
        $response = $this->get('/print/print_jobs/all');
        $response->assertStatus(200);
        $response = $this->get('/print/admin');
        $response->assertStatus(200);
        $response = $this->get('/print/account_history');
        $response->assertStatus(200);

        $response = $this->post('/print/modify_balance', []);
        $response->assertStatus(302);
        $response = $this->post('/print/add_free_pages', []);
        $response->assertStatus(302);
        $response = $this->post('/print/transfer_balance', []);
        $response->assertStatus(302);
        factory(\App\PrintJob::class)->create(['user_id' => $user->id]);
        $response = $this->post('/print/print_jobs/' . $user->printJobs()->first()->id . '/cancel', []);
        $response->assertStatus(200);

        $response = $this->put('/print/print', []);
        $response->assertStatus(302);
    }
}
