<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Amministratore',
            'surname' => 'Globale',
            'email' => 'info@example.it',
            'phone' => '0000000000',
            'password' => bcrypt('cippalippa'),
            'admin' => true,
        ]);
    }
}
