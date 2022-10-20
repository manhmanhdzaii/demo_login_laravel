<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Phạm Doãn Mạnh',
            'email' => 'manh@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s', time()),
            'role' => 'admin',
            'password' => Hash::make('123456'),
        ]);
    }
}