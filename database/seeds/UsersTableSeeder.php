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
            'name' => 'Soros Orsolya',
            'email' => 'root@eotvos.elte.hu',
            'password' => bcrypt('asdasdasd'),
            'permission' => 1,
            'verified' => true
        ]);
        DB::table('print_accounts')->insert([
            'user_id' => '1',
            'balance' => 100,
            'free_pages' => 10,
            'free_page_deadline' => null
        ]);
        factory(App\User::class, 10)->create()->each(function ($user) {
            $user->printAccount()->save(factory(App\PrintAccount::class)->make(['user_id' => $user->id])); 
        });
    }
}
