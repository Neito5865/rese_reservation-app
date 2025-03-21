<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(GenreSeeder::class);
        $this->call(ShopSeeder::class);
        $this->call(ReservationsTableSeeder::class);
        $this->call(ReviewsTableSeeder::class);
    }
}
