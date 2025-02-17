<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Reservation;
use Carbon\Carbon;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reservations = Reservation::all();

        foreach ($reservations as $reservation) {
            Review::insert([
                'user_id' => $reservation->user_id,
                'shop_id' => $reservation->shop_id,
                'reservation_id' => $reservation->id,
                'is_anonymous' => (bool)rand(0, 1),
                'evaluation' => rand(1, 5),
                'comment' => $this->generateRandomComment(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function generateRandomComment()
    {
        $comments = [
            'とても良かったです！',
            'また利用したいと思います。',
            '料理が美味しかったです。',
            '接客が素晴らしかったです。',
            '雰囲気が良かったです。',
            '少し期待はずれでした。',
            '普通でした。',
        ];
        return $comments[array_rand($comments)];
    }
}
