<?php


class AddFirstRolesSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        DB::table('role')->delete();
        DB::query(null, 'ALTER TABLE role AUTO_INCREMENT=0');

        $data = [
            ['name' => 'User']
        ];

        $query = "INSERT INTO role(name) VALUES(:name)";
        foreach ($data as $key => $value) {
            DB::insert($query, [
                'name' => $value['name']
            ]);
        }
    }
}