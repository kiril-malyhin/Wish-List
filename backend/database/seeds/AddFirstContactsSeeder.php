<?php


class AddFirstContactsSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        DB::table('contact')->delete();
        DB::query(null, 'ALTER TABLE contact AUTO_INCREMENT=0');

        $data = [
            [
                'address' => 'c. Minsk, Tolstogo 10 st.',
                'phone' => '+375259173658'
            ]
        ];

        $query = "INSERT INTO contact(address, phone) VALUES(:address, :phone)";
        foreach ($data as $key => $value) {
            DB::insert($query, [
                'address' => $value['address'],
                'phone' => $value['phone']
            ]);
        }
    }
}