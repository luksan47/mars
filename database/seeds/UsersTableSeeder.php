<?php

use Illuminate\Database\Seeder;
use App\User;
use App\PrintAccount;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->createAdmin();
        $this->createCollegist();
        $this->createTenant();
        
        factory(App\User::class, 10)->create()->each(function ($user) {
            $user->printAccount()->save(factory(PrintAccount::class)->make(['user_id' => $user->id]));
        });
    }

    private function createAdmin() {
        $user = User::create([
            'name' => 'Hapák József',
            'email' => 'root@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'verified' => true
        ]);
        factory(App\MacAddress::class, 3)->create(['user_id' => 1]);
        factory(App\InternetAccess::class, 1)->create(['user_id' => 1]);

        $user->printAccount()->save($this->createPrintAccount($user->id));
        $user->roles()->attach(
            Role::where('name', 'admin')->first()->id
        );
    }

    private function createCollegist() {
        $user = User::create([
            'name' => 'Éliás Próféta',
            'email' => 'collegist@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'verified' => true
        ]);
        $user->printAccount()->save($this->createPrintAccount($user->id));
        $user->roles()->attach(
            Role::where('name', 'collegist')->first()->id
        );
    }

    private function createTenant() {
        $user = User::create([
            'name' => 'A külföldi srác',
            'email' => 'tenant@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'verified' => true
        ]);
        $user->printAccount()->save($this->createPrintAccount($user->id));
        $user->roles()->attach(
            Role::where('name', 'tenant')->first()->id
        );
    }

    private function createPrintAccount($userId) {
        return PrintAccount::create([
            'user_id' => $userId,
            'balance' => 100,
            'free_pages' => 10,
            'free_page_deadline' => null //TODO: add valid date
        ]);
    }
}
