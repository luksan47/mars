<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\FreePages;
use App\Models\Workshop;
use App\Models\Role;
use App\Models\User;
use App\Models\MacAddress;
use App\Models\PrintJob;
use App\Models\PersonalInformation;
use App\Models\EducationalInformation;
use App\Models\Semester;
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
        User::factory()->count(50)->create()->each(function ($user) {
            MacAddress::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
            PrintJob::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
            PersonalInformation::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
            EducationalInformation::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
            $user->roles()->attach(Role::getId(Role::COLLEGIST));
            $user->roles()->attach(Role::getId(Role::INTERNET_USER));
            for ($x = 0; $x < rand(1, 3); $x++) {
                $user->faculties()->attach(rand(1, count(Faculty::ALL)));
            }
            for ($x = 0; $x < rand(1, 3); $x++) {
                $user->workshops()->attach(rand(1, count(Workshop::ALL)));
            }
            $user->internetAccess->setWifiUsername();
        });

        //generate random tenants
        User::factory()->count(5)->create()->each(function ($user) {
            MacAddress::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
            PrintJob::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
            PersonalInformation::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
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
        MacAddress::factory()->count(3)->create(['user_id' => $user->id]);
        FreePages::factory()->count(5)->create(['user_id' => $user->id]);
        PrintJob::factory()->count(5)->create(['user_id' => $user->id]);
        PersonalInformation::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
        EducationalInformation::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
        for ($x = 0; $x < rand(1, 3); $x++) {
            $user->faculties()->attach(rand(1, count(Faculty::ALL)));
        }
        for ($x = 0; $x < rand(1, 3); $x++) {
            $user->workshops()->attach(rand(1, count(Workshop::ALL)));
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
        $user->setStatus(Semester::ACTIVE);
    }

    private function createCollegist()
    {
        $user = User::create([
            'name' => 'Éliás Próféta',
            'email' => 'collegist@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'verified' => true,
        ]);
        PrintJob::factory()->count(5)->create(['user_id' => $user->id]);
        $user->roles()->attach(Role::getId(Role::COLLEGIST));
        $user->roles()->attach(Role::getId(Role::PRINTER));
        $user->roles()->attach(Role::getId(Role::INTERNET_USER));
        $user->internetAccess->setWifiUsername();
        PersonalInformation::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
        EducationalInformation::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
        for ($x = 0; $x < rand(1, 3); $x++) {
            $user->faculties()->attach(rand(1, count(Faculty::ALL)));
        }
        for ($x = 0; $x < rand(1, 3); $x++) {
            $user->workshops()->attach(rand(1, count(Workshop::ALL)));
        }
        $user->setStatus(Semester::ACTIVE);
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
        PersonalInformation::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
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
