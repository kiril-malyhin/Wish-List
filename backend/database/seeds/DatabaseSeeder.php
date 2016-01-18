<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AddFirstContactsSeeder::class);
        $this->call(AddFirstCategoriesSeeder::class);
        $this->call(AddFirstRolesSeeder::class);
        $this->call(AddFirstMediaSeeder::class);
        $this->call(AddFirstUsersSeeder::class);
        $this->call(AddFirstWishSeeder::class);
        Model::reguard();
    }
}
