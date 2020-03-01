<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdmin();
        $this->createCollegist();
        $this->createTenant();
        $this->createStaff();

        factory(App\User::class, 10)->create()->each(function ($user) {
            factory(App\MacAddress::class, $user->id % 5)->create(['user_id' => $user->id]);
            factory(App\PrintJob::class, $user->id % 5)->create(['user_id' => $user->id]);
            $user->roles()->attach(Role::getId(Role::COLLEGIST));
            $user->roles()->attach(Role::getId(Role::INTERNET_USER));
            $user->internetAccess->setWifiUsername(); //setWifiUsername();
        });
    }

    private function createAdmin()
    {
        $user = User::create([
            'name' => 'Hapák József',
            'email' => 'root@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'verified' => true,
        ]);
        factory(App\MacAddress::class, 3)->create(['user_id' => $user->id]);
        factory(App\PrintJob::class, 5)->create(['user_id' => $user->id]);
        $user->roles()->attach(Role::getId(Role::PRINT_ADMIN));
        $user->roles()->attach(Role::getId(Role::INTERNET_ADMIN));
        $user->internetAccess->setWifiUsername();
    }

    private function createCollegist()
    {
        $user = User::create([
            'name' => 'Éliás Próféta',
            'email' => 'collegist@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'verified' => true,
        ]);
        factory(App\PrintJob::class, 5)->create(['user_id' => $user->id]);
        $user->roles()->attach(Role::getId(Role::COLLEGIST));
        $user->roles()->attach(Role::getId(Role::PRINTER));
        $user->roles()->attach(Role::getId(Role::INTERNET_USER));
        $user->internetAccess->setWifiUsername();
    }

    private function createTenant()
    {
        $user = User::create([
            'name' => 'David Tenant',
            'email' => 'tenant@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'verified' => true,
        ]);
        $user->roles()->attach(Role::getId(Role::TENANT));
        $user->roles()->attach(Role::getId(Role::INTERNET_USER));
        $user->internetAccess->setWifiUsername();
    }

    private function createStaff()
    {
        $user = User::create([
            'name' => 'Albi',
            'email' => 'pikacsur@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'verified' => true,
        ]);
        $user->roles()->attach(Role::getId(Role::STAFF));
    }
}
