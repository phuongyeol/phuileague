<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => Str::random(10),
        //     'email' => Str::random(10).'@gmail.com',
        //     'password' => bcrypt('password'),
        // ]);

        DB::table('users')->insert([
            'username' => 'phuongtran',
            'email' => 'phuongtran99.k60@gmail.com',
            'password' => bcrypt('12345678'),
            'facebook_link' => 'https://www.facebook.com/phuongyeol'
        ]);
    }
}
