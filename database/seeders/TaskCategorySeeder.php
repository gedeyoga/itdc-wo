<?php

namespace Database\Seeders;

use App\Models\TaskCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TaskCategorySeeder extends Seeder
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
            TaskCategory::create($location);
        }
    }
}
