<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Developer;
use App\Models\Hire;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

//        $this->call(DeveloperTableSeeder::class);
//        $this->call(HireTableSeeder::class);
//        Developer::factory(3)->hasHires(3)->create();
//        Developer::factory()->has(Hire::factory())->create();

//        Developer::factory(1)->create([
//            'name' => 'John Doe',
//            'email' => 'johndoe@gmial.com'
//        ]);

        Developer::factory(3)->hasHires(1, function (array $attributes, Developer $developer) {
            return ['names' => $developer->name];
        })->create();
    }
}
