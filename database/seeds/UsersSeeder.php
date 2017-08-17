<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清除表
        App\Model\User::truncate();

        factory(App\Model\User::class)->create([
            'name'     => 'user',
            'email'    => '656861622@qq.com',
            'password' => bcrypt('654321'),
        ]);

        factory(App\Model\User::class)->create([
            'name'     => 'tiayo',
            'email'    => '474993693@qq.com',
            'password' => bcrypt('654321'),
        ]);
    }
}
