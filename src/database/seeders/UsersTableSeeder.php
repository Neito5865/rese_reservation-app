<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'テストユーザー1',
                'email' => 'user1@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 3,
            ],
            [
                'name' => 'テストユーザー2',
                'email' => 'user2@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 3,
            ],
            [
                'name' => 'テストユーザー3',
                'email' => 'user3@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 3,
            ],
            [
                'name' => 'テストユーザー4',
                'email' => 'user4@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 3,
            ],
            [
                'name' => 'テストユーザー5',
                'email' => 'user5@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 3,
            ],
            [
                'name' => '管理ユーザー1',
                'email' => 'admin1@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 1,
            ],
            [
                'name' => '管理ユーザー2',
                'email' => 'admin2@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 1,
            ],
            [
                'name' => '管理ユーザー3',
                'email' => 'admin3@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 1,
            ],
            [
                'name' => '管理ユーザー4',
                'email' => 'admin4@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 1,
            ],
            [
                'name' => '管理ユーザー5',
                'email' => 'admin5@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 1,
            ],
            [
                'name' => '店舗ユーザー1',
                'email' => 'shop1@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 2,
            ],
            [
                'name' => '店舗ユーザー2',
                'email' => 'shop2@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 2,
            ],
            [
                'name' => '店舗ユーザー3',
                'email' => 'shop3@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 2,
            ],
            [
                'name' => '店舗ユーザー4',
                'email' => 'shop4@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 2,
            ],
            [
                'name' => '店舗ユーザー5',
                'email' => 'shop5@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'role' => 2,
            ],
        ]);
    }
}
