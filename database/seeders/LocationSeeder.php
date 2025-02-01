<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['name' => 'Location 1'],
            ['name' => 'Location 2'],
            ['name' => 'Location 3'],
            ['name' => 'Location 4'],
            ['name' => 'Location 5'],
        ];

        
        foreach ($datas as $location) {
            Location::create($location);
        }
    }
}
