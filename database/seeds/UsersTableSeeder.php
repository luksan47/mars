<?php

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
        DB::table('users')->insert([
            'name' => 'Hapák József',
            'email' => 'root@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'permission' => 1,
            'verified' => true
        ]);
        //factory(App\MacAddress::class, 34)->create(['user_id' => 1]);
        //factory(App\InternetAccess::class, 1)->create(['user_id' => 1]);
        DB::table('print_accounts')->insert([
            'user_id' => '1',
            'balance' => 100,
            'free_pages' => 10,
            'free_page_deadline' => null
        ]);
        factory(App\User::class, 100)->create()->each(function ($user) {
            $user->printAccount()->save(factory(App\PrintAccount::class)->make(['user_id' => $user->id]));
            factory(App\MacAddress::class, $user->id % 5)->create(['user_id' => $user->id]);
        });
    }
}
