<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\FreePages;
use App\Models\Workshop;
use App\Models\Role;
use App\Models\User;
use App\Models\MacAddress;
use App\Models\PrintJob;
use App\Models\WifiConnection;
use App\Models\PrintAccount;
use App\Models\PersonalInformation;
use App\Models\EducationalInformation;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSuperUser();
        $this->createStaff();

        //generate collegists

        $collegist = User::create([
            'name' => 'Éliás Próféta',
            'email' => 'collegist@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'verified' => true,
        ]);
        $this->createCollegist($collegist);
        $collegist->printAccount()->save(PrintAccount::factory()->make(['user_id' => $collegist->id]));
        $collegist->personalInformation()->save(PersonalInformation::factory()->make(['user_id' => $collegist->id]));

        User::factory()->count(50)->create()->each(function ($user) {
            $this->createCollegist($user);
        });

        //generate tenants

        $tenant = User::create([
            'name' => 'David Tenant',
            'email' => 'tenant@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'verified' => true,
        ]);
        $this->createTenant($tenant);
        $tenant->printAccount()->save(PrintAccount::factory()->make(['user_id' => $tenant->id]));
        $tenant->personalInformation()->save(PersonalInformation::factory()->make(['user_id' => $tenant->id]));

        User::factory()->count(5)->create()->each(function ($user) {
            $this->createTenant($user);
        });
    }

    private function createSuperUser()
    {
        $user = User::create([
            'name' => 'Hapák József',
            'email' => config('mail.test_mail'),
            'password' => bcrypt('asdasdasd'),
            'verified' => true,
        ]);
        $user->printAccount()->save(PrintAccount::factory()->make(['user_id' => $user->id]));
        $user->personalInformation()->save(PersonalInformation::factory()->make(['user_id' => $user->id]));
        MacAddress::factory()->count(3)->create(['user_id' => $user->id]);
        FreePages::factory()->count(5)->create(['user_id' => $user->id]);
        PrintJob::factory()->count(5)->create(['user_id' => $user->id]);
        $user->educationalInformation()->save(EducationalInformation::factory()->make(['user_id' => $user->id]));
        for ($x = 0; $x < rand(1, 3); $x++) {
            $user->faculties()->attach(rand(1, count(Faculty::ALL)));
        }
        for ($x = 0; $x < rand(1, 3); $x++) {
            $user->workshops()->attach(rand(1, count(Workshop::ALL)));
        }
        foreach (Role::ALL as $role) {
            if (Role::canHaveObjectFor($role)) {
                $objects = Role::possibleObjectsFor($role);
                foreach ($objects as $object) {
                    $user->roles()->attach(Role::getId($role), ['object_id' => $object->id]);
                }
            } else {
                $user->roles()->attach(Role::getId($role));
            }
        }
        $wifi_username = $user->internetAccess->setWifiUsername();
        WifiConnection::factory($user->id % 5)->create(['wifi_username' => $wifi_username]);
    }

    private function createCollegist($user)
    {
        MacAddress::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
        PrintJob::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
        $user->roles()->attach(
            Role::getId(Role::COLLEGIST),
            [
                'object_id' => rand(
                    Role::getObjectIdByName(Role::COLLEGIST, 'resident'),
                    Role::getObjectIdByName(Role::COLLEGIST, 'extern')
                )
            ]
        );
        $user->educationalInformation()->save(EducationalInformation::factory()->make(['user_id' => $user->id]));
        $user->roles()->attach(Role::getId(Role::PRINTER));
        $user->roles()->attach(Role::getId(Role::INTERNET_USER));
        $wifi_username = $user->internetAccess->setWifiUsername();
        WifiConnection::factory($user->id % 5)->create(['wifi_username' => $wifi_username]);
        for ($x = 0; $x < rand(1, 3); $x++) {
            $faculty = rand(1, count(Faculty::ALL));
            if ($user->faculties()->where('faculty_users.faculty_id', $faculty)->count() == 0) {
                $user->faculties()->attach($faculty);
            }
        }
        for ($x = 0; $x < rand(1, 3); $x++) {
            $workshop = rand(1, count(Workshop::ALL));
            if ($user->workshops()->where('workshop_users.workshop_id', $workshop)->count() == 0)
                $user->workshops()->attach($workshop);
        }
    }

    private function createTenant($user)
    {
        $user->roles()->attach(Role::getId(Role::TENANT));
        $user->roles()->attach(Role::getId(Role::INTERNET_USER));
        $wifi_username = $user->internetAccess->setWifiUsername();
        WifiConnection::factory($user->id % 5)->create(['wifi_username' => $wifi_username]);
        MacAddress::factory()->count($user->id % 5)->create(['user_id' => $user->id]);
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
