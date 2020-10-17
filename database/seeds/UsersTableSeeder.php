<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'シーダー君',
            'age' => 50,
            'email' => 'seeder-kun@mail.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'name' => 'シーダーちゃん',
            'age' => 20,
            'email' => 'seeder-chan@mail.com',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'name' => Str::random(10),
            'age' => 20,
            'email' => Str::random(10) . '@mail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
