<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;
use Carbon\Carbon;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = [
            'イタリアン',
            'ラーメン',
            '居酒屋',
            '寿司',
            '焼肉',
        ];

        $now = Carbon::now();

        $data = array_map(function($genre) use ($now) {
            return [
                'content' => $genre,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $genres);

        Genre::insert($data);
    }
}
