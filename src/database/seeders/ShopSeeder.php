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
                'user_id' => $data[1],
                'area_id' => $data[2],
                'genre_id' => $data[3],
                'shopName' => $data[4],
                'detail' => $data[5],
                'shopImg' => $data[6],
            ]);
        }

        fclose($file);
    }
}
