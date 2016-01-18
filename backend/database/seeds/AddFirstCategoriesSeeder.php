<?php

class AddFirstCategoriesSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        DB::table('category')->delete();
        DB::query(null, 'ALTER TABLE category AUTO_INCREMENT=0');

        $data = [
            ['name' => 'Friends'],
            ['name' => 'Family'],
            ['name' => 'Colleagues'],
            ['name' => 'All']
        ];

        $query = "INSERT INTO category(name) VALUES(:name)";
        foreach ($data as $key => $value) {
            DB::insert($query, [
                'name' => $value['name']
            ]);
        }
    }
}