<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Tests\TestCase;

class PrintControllerTest extends TestCase
{
    /**
     * Testing a verified user with no printing related permissions.
     */
    public function testUserWithoutPermissions()
    {
        $user = User::factory()->create();
        $user->setVerified();
        $this->actingAs($user);

        // The user is not allowed to see the page without the correct permissions.
        // TODO: test this with freshly registered user.
        $response = $this->get('/print');
        $response->assertStatus(403);
        $response = $this->get('/print/free_pages/list');
        $response->assertStatus(403);
        $response = $this->get('/print/print_jobs/list');
        $response->assertStatus(403);
        $response = $this->get('/print/free_pages/list/all');
        $response->assertStatus(403);
        $response = $this->get('/print/print_jobs/list/all');
        $response->assertStatus(403);
        $response = $this->get('/print/manage');
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
        $user = User::factory()->create();
        $user->setVerified();
        $user->roles()->attach(Role::getId(Role::PRINTER));
        $this->actingAs($user);

        $response = $this->get('/print');
        $response->assertStatus(200);
        $response = $this->get('/print/free_pages/list');
        $response->assertStatus(200);
        $response = $this->get('/print/print_jobs/list');
        $response->assertStatus(200);
        $response = $this->get('/print/free_pages/list/all');
        $response->assertStatus(403);
        $response = $this->get('/print/print_jobs/list/all');
        $response->assertStatus(403);
        $response = $this->get('/print/manage');
        $response->assertStatus(403);
        $response = $this->get('/print/account_history');
        $response->assertStatus(403);

        $response = $this->post('/print/modify_balance', []);
        $response->assertStatus(403);
        $response = $this->post('/print/add_free_pages', []);
        $response->assertStatus(403);
        $response = $this->post('/print/transfer_balance', []);
        $response->assertStatus(302);
        $printJob = \App\Models\PrintJob::factory()->create(['user_id' => $user->id]);
        $response = $this->post('/print/print_jobs/' . $printJob->id . '/cancel', []);
        $response->assertStatus(200);

        $response = $this->put('/print/print', []);
        $response->assertStatus(302);
    }

    /**
     * Testing a verified user with PRINT_ADMIN permission.
     */
    public function testUserWithPrintAdminPermissions()
    {
        $user = User::factory()->create();
        $user->setVerified();
        $user->roles()->attach(Role::getId(Role::PRINT_ADMIN));
        $this->actingAs($user);

        $response = $this->get('/print');
        $response->assertStatus(200);
        $response = $this->get('/print/free_pages/list');
        $response->assertStatus(200);
        $response = $this->get('/print/print_jobs/list');
        $response->assertStatus(200);
        $response = $this->get('/print/free_pages/list/all');
        $response->assertStatus(200);
        $response = $this->get('/print/print_jobs/list/all');
        $response->assertStatus(200);
        $response = $this->get('/print/manage');
        $response->assertStatus(200);
        $response = $this->get('/print/account_history');
        $response->assertStatus(200);

        $response = $this->post('/print/modify_balance', []);
        $response->assertStatus(302);
        $response = $this->post('/print/add_free_pages', []);
        $response->assertStatus(302);
        $response = $this->post('/print/transfer_balance', []);
        $response->assertStatus(302);
        $printJob = \App\Models\PrintJob::factory()->create(['user_id' => $user->id]);
        $response = $this->post('/print/print_jobs/' . $printJob->id . '/cancel', []);
        $response->assertStatus(200);

        $response = $this->put('/print/print', []);
        $response->assertStatus(302);
    }

    public function testBalanceTransfer()
    {
        $sender = User::factory()->create();
        $sender->setVerified();
        $sender->roles()->attach(Role::getId(Role::PRINTER));
        $this->actingAs($sender);

        $reciever = User::factory()->create();
        $reciever->setVerified();
        $reciever->roles()->attach(Role::getId(Role::PRINTER));

        // Setting initial valeus
        $this->assertEquals($sender->printAccount->balance, 0);
        $sender->printAccount->update(['last_modified_by' => $sender->id]);
        $sender->printAccount->increment('balance', 43);
        $this->assertEquals($sender->printAccount->balance, 43);
        $this->assertEquals($reciever->printAccount->balance, 0);

        // Simple transfer test
        $response = $this->transfer($reciever, 10);
        $this->assertCorrectTransfer($response, $sender, $reciever, 33, 10);

        // Transferring values over balance
        $response = $this->transfer($reciever, 123);
        $response = $this->transfer($reciever, 34);
        $this->assertCorrectTransfer($response, $sender, $reciever, 33, 10);

        // Transferring nothing
        $response = $this->transfer($reciever, 0);
        $this->assertCorrectTransfer($response, $sender, $reciever, 33, 10);

        // Transferring negative values
        $response = $this->transfer($reciever, -5);
        $this->assertCorrectTransfer($response, $sender, $reciever, 33, 10);

        // Transferring all balance
        $response = $this->transfer($reciever, 33);
        $this->assertCorrectTransfer($response, $sender, $reciever, 0, 43);

        // Transferring with empty balance
        $response = $this->transfer($reciever, 1);
        $this->assertCorrectTransfer($response, $sender, $reciever, 0, 43);
    }

    public function testModifyBalance()
    {
        $sender = User::factory()->create();
        $sender->setVerified();
        $sender->roles()->attach(Role::getId(Role::PRINT_ADMIN));
        $this->actingAs($sender);

        $reciever = User::factory()->create();
        $reciever->setVerified();
        $reciever->roles()->attach(Role::getId(Role::PRINTER));

        // Asserting initial valeus
        $this->assertEquals($sender->printAccount->balance, 0);
        $this->assertEquals($reciever->printAccount->balance, 0);

        $response = $this->modify($reciever, 10);
        $this->assertCorrectModification($response, $reciever, 10);

        $response = $this->modify($reciever, 123);
        $this->assertCorrectModification($response, $reciever, 133);

        $response = $this->modify($reciever, -23);
        $this->assertCorrectModification($response, $reciever, 110);

        $response = $this->modify($reciever, 1);
        $this->assertCorrectModification($response, $reciever, 111);

        $response = $this->modify($reciever, 0);
        $this->assertCorrectModification($response, $reciever, 111);

        $response = $this->modify($reciever, -112);
        $this->assertCorrectModification($response, $reciever, 111);

        $response = $this->modify($reciever, -111);
        $this->assertCorrectModification($response, $reciever, 0);

        $response = $this->modify($reciever, -1);
        $this->assertCorrectModification($response, $reciever, 0);

        $response = $this->modify($reciever, 0);
        $this->assertCorrectModification($response, $reciever, 0);

        $response = $this->modify($reciever, 12);
        $this->assertCorrectModification($response, $reciever, 12);

        //Sender is not affected
        $this->assertEquals($sender->printAccount->balance, 0);
    }

    // Helpers
    private function transfer($reciever, $balance) {
        $response = $this->post('/print/transfer_balance', [
            'user_to_send' => $reciever->id,
            'balance' => $balance,
        ]);
        return $response;
    }
    private function assertCorrectTransfer($response, $sender, $reciever, $senderBalance, $receiverBalance)
    {
        $response->assertStatus(302);
        $reciever = User::find($reciever->id); // We have to reload the reciever here.
        $this->assertEquals($sender->printAccount->balance, $senderBalance);
        $this->assertEquals($reciever->printAccount->balance, $receiverBalance);
    }

    private function modify($reciever, $balance) {
        $response = $this->post('/print/modify_balance', [
            'user_id_modify' => $reciever->id,
            'balance' => $balance,
        ]);
        return $response;
    }
    private function assertCorrectModification($response, $reciever, $receiverBalance)
    {
        $response->assertStatus(302);
        $reciever = User::find($reciever->id); // We have to reload the reciever here.
        $this->assertEquals($reciever->printAccount->balance, $receiverBalance);
    }


}
