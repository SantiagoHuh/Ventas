<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // datos de roles debe ejecutarse primero
        $this->call(RoleTableSeeder::class);

        // los usuarios necesitarán los roles
        $this->call(UserTableSeeder::class);
    }
}
