<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pompa;

class PompaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name' => 'Pompa Irigasi 1',
                'merk' => 'RUCIKA',
                'year' => '2020',
                'type' => 'irigasi',
                'power_kwh' => 7.2,
                'capacity' => 11,
                'status' => 'active'
            ],
            [
                'name' => 'Pompa Limbah 1',
                'merk' => 'RUCIKA',
                'year' => '2020',
                'type' => 'limbah',
                'power_kwh' => 7.2,
                'capacity' => 11,
                'status' => 'active'
            ],
            [
                'name' => 'Pompa Irigasi 2',
                'merk' => 'RUCIKA',
                'year' => '2020',
                'type' => 'irigasi',
                'power_kwh' => 7.2,
                'capacity' => 11,
                'status' => 'active'
            ],
            [
                'name' => 'Pompa Limbah 2',
                'merk' => 'RUCIKA',
                'year' => '2020',
                'type' => 'limbah',
                'power_kwh' => 7.2,
                'capacity' => 11,
                'status' => 'active'
            ],
        ];

        
        foreach ($datas as $pompa) {
            Pompa::create($pompa);
        }
    }
}
