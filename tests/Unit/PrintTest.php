<?php

namespace Tests\Unit;

use App\User;
use App\Role;
use App\PrintAccount;
use App\Http\Controllers\PrintController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PrintTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testPrintAccount()
    {
        $user = factory(User::class)->create();
        //$user->roles()->attach(Role::getId(Role::PRINTER));

        $this->assertNotNull($user->printAccount);
        $this->assertEquals($user->printAccount, PrintAccount::find($user->id));

        $this->assertEquals($user->printAccount->balance, 0);
        $this->assertFalse($user->printAccount->hasEnoughMoney(1));
        $this->assertTrue($user->printAccount->hasEnoughMoney(0));

        $user->printAccount->update(['last_modified_by' => $user->id]);
        $user->printAccount->increment('balance', 43);
        $this->assertTrue($user->printAccount->hasEnoughMoney(43));
        $this->assertTrue($user->printAccount->hasEnoughMoney(15));
        $this->assertFalse($user->printAccount->hasEnoughMoney(44));
        $this->assertFalse($user->printAccount->hasEnoughMoney(112));
        $this->assertTrue($user->printAccount->hasEnoughMoney(-43));
        $this->assertFalse($user->printAccount->hasEnoughMoney(-44));
    }
}
