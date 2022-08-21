<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Hire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeveloperTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Developer::factory()->has(Hire::factory()->count(5))->create();
    }
}
