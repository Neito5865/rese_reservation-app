<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = range(1, 5);
        $shops = range(1, 20);
        $startDate = Carbon::create(2024, 9, 1, 9, 0, 0);
        $endDate = Carbon::now();

        foreach ($users as $user) {
            foreach ($shops as $shop) {
                for ($i = 1; $i <=3; $i++) {
                    $randomDate = Carbon::createFromTimestamp(
                        rand($startDate->timestamp, $endDate->timestamp)
                    );
                    $randomMinutes = rand(0, 95) * 15;
                    $randomTime = Carbon::create($randomDate->year, $randomDate->month, $randomDate->day, 0, 0, 0)->addMinutes($randomMinutes);

                    DB::table('reservations')->insert([
                        'user_id' => $user,
                        'shop_id' => $shop,
                        'date' => $randomDate->toDateString(),
                        'time' => $randomTime->toTimeString(),
                        'numberPeople' => rand(1, 10),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
