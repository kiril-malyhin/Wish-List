<?php

use Illuminate\Support\Facades\URL;

class AddFirstMediaSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        DB::table('media')->delete();
        DB::query(null, 'ALTER TABLE media AUTO_INCREMENT=0');

        $data = [
            ['name' => URL::to('/').'/images/users/default-user.png'],
            ['name' => 'default-image.png'],
            ['name' => URL::to('/').'/images/wishes/iphone.jpg']
        ];

        $query = "INSERT INTO media(name) VALUES(:name)";
        foreach ($data as $key => $value) {
            DB::insert($query, [
                'name' => $value['name']
            ]);
        }
    }
}