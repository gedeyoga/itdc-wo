<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $datas = [
            ['name' => 'High'],
            ['name' => 'Medium'],
            ['name' => 'Low'],
        ];

        foreach ($datas as $data) {
            Priority::create($data);
        }
    }
}
