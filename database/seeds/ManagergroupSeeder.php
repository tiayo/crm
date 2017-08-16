<?php

use Illuminate\Database\Seeder;

class ManagergroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清除表
        App\Model\Managergroup::truncate();

        factory(App\Model\Managergroup::class)->create([
            'name' => '系统管理员',
            'rule' => serialize(0),
        ]);

        factory(App\Model\Managergroup::class)->create([
            'parent_id' => App\Model\Managergroup::first()['managergroup_id'],
            'name' => '插件管理员',
            'rule' => serialize(0),
        ]);
    }
}
