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
        App\Model\Manage::truncate();

        factory(App\Model\Manage::class)->create([
            'name' => 'manage',
            'email' => '656861622@qq.com',
            'type' => 1,
            'group' => $managergroup->first()['managergroup_id'],
            'password' => bcrypt('654321'),
        ]);

        factory(App\Model\Manage::class)->create([
            'name' => 'admin',
            'email' => '474993693@qq.com',
            'type' => 2,
            'group' => $managergroup->skip(1)->first()['managergroup_id'],
            'password' => bcrypt('654321'),
        ]);
    }
}
