<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(storage_path('app/public/areas.csv'), 'r');

        $header = fgetcsv($file);

        while(($data = fgetcsv($file)) !== FALSE){
            Area::create([
                'area' => $data[1],
            ]);
        }

        fclose($file);
    }
}
