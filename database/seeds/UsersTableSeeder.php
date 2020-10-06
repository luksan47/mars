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

        //generate random collegists
        factory(App\User::class, 50)->create()->each(function ($user) {
            factory(App\MacAddress::class, $user->id % 5)->create(['user_id' => $user->id]);
            factory(App\PrintJob::class, $user->id % 5)->create(['user_id' => $user->id]);
            factory(App\PersonalInformation::class, $user->id % 5)->create(['user_id' => $user->id]);
            factory(App\EducationalInformation::class, $user->id % 5)->create(['user_id' => $user->id]);
            $user->roles()->attach(Role::getId(Role::COLLEGIST));
            $user->roles()->attach(Role::getId(Role::INTERNET_USER));
            for ($x = 0; $x < rand(1, 3); $x++) {
                $user->faculties()->attach(rand(1, count(App\Faculty::ALL)));
            }
            for ($x = 0; $x < rand(1, 3); $x++) {
                $user->workshops()->attach(rand(1, count(App\Workshop::ALL)));
            }
            $user->internetAccess->setWifiUsername();
        });

        //generate random tenants
        factory(App\User::class, 5)->create()->each(function ($user) {
            factory(App\MacAddress::class, $user->id % 5)->create(['user_id' => $user->id]);
            factory(App\PrintJob::class, $user->id % 5)->create(['user_id' => $user->id]);
            factory(App\PersonalInformation::class, $user->id % 5)->create(['user_id' => $user->id]);
            $user->roles()->attach(Role::getId(Role::TENANT));
            $user->roles()->attach(Role::getId(Role::INTERNET_USER));
            $user->internetAccess->setWifiUsername();
        });
    }

    private function createAdmin()
    {
        $user = User::create([
            'name' => 'Hapák József',
            'email' => config('mail.test_mail'),
            'password' => bcrypt('asdasdasd'),
            'verified' => true,
        ]);
        factory(App\MacAddress::class, 3)->create(['user_id' => $user->id]);
        factory(\App\FreePages::class, 5)->create(['user_id' => $user->id]);
        factory(App\PrintJob::class, 5)->create(['user_id' => $user->id]);
        factory(App\PersonalInformation::class, $user->id % 5)->create(['user_id' => $user->id]);
        factory(App\EducationalInformation::class, $user->id % 5)->create(['user_id' => $user->id]);
        for ($x = 0; $x < rand(1, 3); $x++) {
            $user->faculties()->attach(rand(1, count(App\Faculty::ALL)));
        }
        for ($x = 0; $x < rand(1, 3); $x++) {
            $user->workshops()->attach(rand(1, count(App\Workshop::ALL)));
        }
        foreach (Role::ALL as $role) {
            if (Role::canHaveObjectFor($role)) {
                $objects = Role::possibleObjectsFor($role);
                foreach ($objects as $key => $value) {
                    $user->roles()->attach(Role::getId($role), ['object_id' => $key]);
                }
            } else {
                $user->roles()->attach(Role::getId($role));
            }
        }
        $user->internetAccess->setWifiUsername();
        $user->setStatus(\App\Semester::ACTIVE);
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
        factory(App\PersonalInformation::class, $user->id % 5)->create(['user_id' => $user->id]);
        factory(App\EducationalInformation::class, $user->id % 5)->create(['user_id' => $user->id]);
        for ($x = 0; $x < rand(1, 3); $x++) {
            $user->faculties()->attach(rand(1, count(App\Faculty::ALL)));
        }
        for ($x = 0; $x < rand(1, 3); $x++) {
            $user->workshops()->attach(rand(1, count(App\Workshop::ALL)));
        }
        $user->setStatus(\App\Semester::ACTIVE);
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
        factory(App\PersonalInformation::class, $user->id % 5)->create(['user_id' => $user->id]);
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
