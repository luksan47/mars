<?php

namespace Database\Seeders;

use App\Models\DocumentRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class DocumentRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::limit(10)->inRandomOrder()->get();
        foreach ($users as $user) {
            $request = DocumentRequest::factory()->create();
            $user->documentRequests()->save($request);
        }
    }
}
