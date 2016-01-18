<?php

use Illuminate\Database\Seeder;

class AddFirstUsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('user')->delete();
        DB::query(null, 'ALTER TABLE user AUTO_INCREMENT=0');

        $users = [
            [
                'first_name' => 'Ivan',
                'last_name' => 'Ivanov',
                'role_id' => 1,
                'media_id' => 1,
                'contact_id' => 1,
                'email' => 'test@test.ru',
                'password' => Hash::make('qwerty')
            ]
        ];

        $query = "INSERT INTO user(first_name, last_name, role_id, media_id, contact_id, email, password) VALUES(:first_name, :last_name, :role_id, :media_id, :contact_id, :email, :password)";
        foreach ($users as $key => $value) {
            DB::insert($query, [
                'first_name' => $value['first_name'],
                'last_name' => $value['last_name'],
                'role_id' => $value['role_id'],
                'media_id' => $value['media_id'],
                'contact_id' => $value['contact_id'],
                'email' => $value['email'],
                'password' => $value['password']
            ]);
        }
    }
}