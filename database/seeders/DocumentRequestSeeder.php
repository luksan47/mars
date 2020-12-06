<?php

namespace Database\Seeders;

use App\Models\DocumentRequest;
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
        DocumentRequest::factory()->count(10)->create();
    }
}
