<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
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
        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now()->addMonths(6);
        $minPastReservations = 50;

        $reservations = [];

        foreach ($users as $user) {
            foreach ($shops as $shop) {
                for ($i = 1; $i <=2; $i++) {
                    $randomDate = Carbon::createFromTimestamp(
                        rand($startDate->timestamp, $endDate->timestamp)
                    );
                    $randomMinutes = rand(0, 95) * 15;
                    $randomTime = Carbon::create($randomDate->year, $randomDate->month, $randomDate->day, 0, 0, 0)->addMinutes($randomMinutes);

                    $reservations[] = [
                        'user_id' => $user,
                        'shop_id' => $shop,
                        'date' => $randomDate->toDateString(),
                        'time' => $randomTime->toTimeString(),
                        'number_people' => rand(1, 10),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        Reservation::insert($reservations);

        $pastReservationsCount = Reservation::where('date', '<', now()->toDateString())->count();

        if ($pastReservationsCount < $minPastReservations) {
            $additionalReservations = [];

                while ($pastReservationsCount < $minPastReservations) {
                    $randomUser = rand(1, 5);
                $randomShop = rand(1, 20);
                $randomDate = Carbon::createFromTimestamp(rand($startDate->timestamp, now()->timestamp));
                $randomMinutes = rand(0, 95) * 15;
                $randomTime = Carbon::create($randomDate->year, $randomDate->month, $randomDate->day, 0, 0, 0)->addMinutes($randomMinutes);

                $additionalReservations[] = [
                    'user_id' => $randomUser,
                    'shop_id' => $randomShop,
                    'date' => $randomDate->toDateString(),
                    'time' => $randomTime->toTimeString(),
                    'number_people' => rand(1, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $pastReservationsCount++;
            }

            Reservation::insert($additionalReservations);
        }
    }
}
