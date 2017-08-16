<?php

use Illuminate\Database\Seeder;

class ManagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\App\Model\Managergroup $managergroup)
    {
        //清除表
        App\Model\Manager::truncate();

        factory(App\Model\Manager::class)->create([
            'name' => 'manage',
            'email' => '656861622@qq.com',
            'type' => 1,
            'group' => 0,
            'password' => bcrypt('654321'),
        ]);

        factory(App\Model\Manager::class)->create([
            'name' => 'admin',
            'email' => '474993693@qq.com',
            'type' => 2,
            'group' => $managergroup->orderby('managergroup_id')->first()['managergroup_id'],
            'password' => bcrypt('654321'),
        ]);

        factory(App\Model\Manager::class)->create([
            'name' => 'plugins',
            'email' => 'admin@qq.com',
            'type' => 2,
            'group' => $managergroup->skip(1)->orderby('managergroup_id')->first()['managergroup_id'],
            'password' => bcrypt('654321'),
        ]);
    }
}
