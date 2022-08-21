<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Developer::factory(5)->hasHires(5, function (array $attributes, Developer $developer) {
            return ['names' => $developer->name];
        })->create();
    }
}
