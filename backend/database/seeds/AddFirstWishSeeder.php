<?php

use Illuminate\Database\Seeder;

class AddFirstWishSeeder extends Seeder
{
    public function run()
    {
        DB::table('wish')->delete();
        DB::query(null, 'ALTER TABLE wish AUTO_INCREMENT=0');

        $data = [
            [
                'user_id' => '1',
                'name' => 'Iphone',
                'media_id' => '3',
                'description' => 'Very good phone',
                'link' => 'http://catalog.onliner.by/mobile/apple/iphone6_16gb',
                'category_id' => '2',
                'publish_state' => '1',
                'present_state' => '1'

            ]
        ];

        $query = "INSERT INTO wish(user_id,name, media_id, description, link, category_id,publish_state,present_state)
                  VALUES(:user_id,:name, :media_id, :description, :link, :category_id,:publish_state,:present_state)";
        foreach ($data as $key => $value) {
            DB::insert($query, [
                'user_id' => $value['user_id'],
                'name' => $value['name'],
                'media_id' => $value['media_id'],
                'description' => $value['description'],
                'link' => $value['link'],
                'category_id' => $value['category_id'],
                'publish_state' => $value['publish_state'],
                'present_state' => $value['present_state']
            ]);
        }
    }
}