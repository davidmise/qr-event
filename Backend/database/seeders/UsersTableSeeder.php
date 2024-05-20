<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            //admin
            [
                'name' =>  'doorman',
                'username' =>  'doorman',
                'email' => 'doorman@creativehub.com',
                'password' => Hash::make('password'),
                'role' => 'doorman',
            ],

            //admin
            [
                'name' =>  'Admin',
                'username' =>  'admin',
                'email' => 'admin@creativehub.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],

            //host
            [
                'name' =>  'Host',
                'username' =>  'Host',
                'email' => 'host@creativehub.com',
                'password' => Hash::make('password'),
                'role' => 'host',
            ]
        ]);
                    }
}
