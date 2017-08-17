<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清除表
        App\Model\Admin::truncate();

        factory(App\Model\Admin::class)->create([
            'name'     => 'admin',
            'email'    => '656861622@qq.com',
            'password' => bcrypt('654321'),
        ]);

        factory(App\Model\Admin::class)->create([
            'name'     => 'tiayo',
            'email'    => '474993693@qq.com',
            'password' => bcrypt('654321'),
        ]);
    }
}
