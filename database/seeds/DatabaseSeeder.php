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
        $this->call(ManagergroupSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ManagesSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
