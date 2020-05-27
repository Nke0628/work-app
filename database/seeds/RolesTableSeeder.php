<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('roles')->insert([
            [
                'id' => '1',
                'description' => 'システム管理者'
            ],
            [
                'id' => '5',
                'description' => 'ユーザ'
            ],
            [
                'id' => '10',
                'description' => 'スタッフ'
            ]
        ]);
    }
}
