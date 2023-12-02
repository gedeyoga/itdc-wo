<?php

namespace Database\Seeders;

use App\Models\JenisPura;
use App\Models\SensorPintu;
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
        // User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(RolePermissions::class);
        $this->call(UserSeeder::class);
        $this->call(TaskCategorySeeder::class);
        $this->call(PrioritySeeder::class);
        $this->call(LocationSeeder::class);
    }
}
