<?php

use App\Role;
use App\User;
use APP\PersonalInformation;
use APP\EducationalInformation;
use APP\Faculty;
use APP\Workshop;
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
            $user->internetAccess->setWifiUsername();
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
        PersonalInformation::create([
            'user_id' => $user->id,
            'place_of_birth' => "Budapest",
            'date_of_birth' => "1895-01-01",
            'mothers_name' => "ELTE",
            'phone_number' => "+36 (20) 123-4567",
            'country' => "Hungary",
            'county' => "Pest",
            'zip_code' => "1118",
            'city' => "Budapest",
            'street_and_number' => "Ménesi út 11-13",
        ]);
        App\EducationalInformation::create([
            'user_id' => $user->id,
            'year_of_graduation' => "2000",
            'high_school' => "Seholse",
            'neptun' => "ABC123",
            'year_of_acceptance' => "2010",
        ]);
        $user->faculties()->attach(1);
        $user->faculties()->attach(4);
        $user->workshops()->attach(1);
        $user->workshops()->attach(4);
        $user->workshops()->attach(5);
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
        PersonalInformation::create([
            'user_id' => $user->id,
            'place_of_birth' => "New York",
            'date_of_birth' => "1972-12-31",
            'mothers_name' => "David's Mother",
            'phone_number' => "+36 (20) 123-4567",
            'country' => "USA",
            'county' => "New York",
            'zip_code' => "1234",
            'city' => "New York",
            'street_and_number' => "Somestreet 50M3NUMB3R.",
        ]);
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
