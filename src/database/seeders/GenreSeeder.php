<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen(storage_path('app/public/genres.csv'), 'r');

        $header = fgetcsv($file);

        while(($data = fgetcsv($file)) !== FALSE){
            Genre::create([
                'genre' => $data[1],
            ]);
        }

        fclose($file);
    }
}
