<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(storage_path('app/public/shops.csv'), 'r');

        $header = fgetcsv($file);

        while(($data = fgetcsv($file)) !== FALSE){
            Shop::create([
                'area_id' => $data[1],
                'genre_id' => $data[2],
                'shopName' => $data[3],
                'detail' => $data[4],
                'shopImg' => $data[5],
            ]);
        }

        fclose($file);
    }
}
