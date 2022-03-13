<?php

namespace Tests\Feature;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Secretariat\RegistrationsController;
use App\Models\PersonalInformation;
use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Collegist registration.
     *
     * @return void
     */
    public function test_register_collegist()
    {
        $controller = new RegisterController();
        $user_data = User::factory()->make()->only('name', 'email');
        $personal_info_data = PersonalInformation::factory()->make()->toArray();
        $controller->create(array_merge([
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'user_type' => 'collegist'],
            $user_data,
            $personal_info_data
        ));

        $this->assertDatabaseHas('users', array_merge(
            $user_data,
            ['verified' => 'false']
        ));
        $user = User::where('email', $user_data['email'])->firstOrFail();
        $this->assertTrue(Hash::check('secret', $user->password));
        $this->assertDatabaseHas('personal_information', array_merge(
            ['user_id' => $user->id],
            $personal_info_data
        ));
        $this->assertDatabaseHas('internet_accesses', [
            'user_id' => $user->id,
        ]);
        $this->assertDatabaseHas('print_accounts', [
            'user_id' => $user->id,
            'balance' => 0
        ]);

        $this->assertTrue($user->hasRoleBase(Role::PRINTER));
        $this->assertTrue($user->hasRoleBase(Role::INTERNET_USER));
        $this->assertTrue($user->hasRoleBase(Role::COLLEGIST));

        $this->assertNotNull($user->application);
    }


    /**
     * Test Tenant registration.
     *
     * @return void
     */
    public function test_tenant_collegist()
    {
        $controller = new RegisterController();

        $user_data = User::factory()->make()->only('name', 'email');
        $personal_info_data = PersonalInformation::factory()->make()->toArray();
        $controller->create(array_merge([
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'user_type' => 'tenant'],
            $user_data,
            $personal_info_data
        ));

        $this->assertDatabaseHas('users', array_merge(
            $user_data,
            ['verified' => 'false']
        ));
        $user = User::where('email', $user_data['email'])->firstOrFail();
        $this->assertTrue(Hash::check('secret', $user->password));
        $this->assertDatabaseHas('personal_information', array_merge(
            ['user_id' => $user->id],
            $personal_info_data
        ));
        $this->assertDatabaseHas('internet_accesses', [
            'user_id' => $user->id,
            'wifi_username' => 'wifiuser'.$user->id
        ]);
        $this->assertDatabaseHas('print_accounts', [
            'user_id' => $user->id,
            'balance' => 0
        ]);

        $this->assertTrue($user->hasRoleBase(Role::PRINTER));
        $this->assertTrue($user->hasRoleBase(Role::INTERNET_USER));
        $this->assertTrue($user->hasRoleBase(Role::TENANT));
    }

}
