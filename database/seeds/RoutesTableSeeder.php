<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoutesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::table('routes')->insert([
            [
                'id' => '1',
                'user_id' => 4,
                'stage' => 1,
                'target_user_id' => 4
            ],
            [
                'id' => '2',
                'user_id' => 4,
                'stage' => 1,
                'target_user_id' => 6
            ],
            [
                'id' => '3',
                'user_id' => 4,
                'stage' => 2,
                'target_user_id' => 4
            ],
            [
                'id' => '4',
                'user_id' => 6,
                'stage' => 1,
                'target_user_id' => 4
            ],
        ]);
    }
}
