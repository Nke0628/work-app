<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeetingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Db::table('meeting_tabs')->insert([
//            [
//                'suriawase_tab_id' => 1,
//                'suriawase_config_id' => 1,
//                'tab_name' => '基本情報',
//                'tab_no' => 1
//            ],
//            [
//                'suriawase_tab_id' => 2,
//                'suriawase_config_id' => 1,
//                'tab_name' => '査定',
//                'tab_no' => 2
//            ],
//        ]);
//
//        Db::table('meeting_items')->insert([
//            [
//                'suriawase_item_id' => 1,
//                'suriawase_config_id' => 1,
//                'suriawase_tab_id' => 1,
//                'item_name' => '名前',
//                'item_no' => 1
//            ],
//            [
//                'suriawase_item_id' => 2,
//                'suriawase_config_id' => 1,
//                'suriawase_tab_id' => 1,
//                'item_name' => '性別',
//                'item_no' => 2
//            ],
//            [
//                'suriawase_item_id' => 3,
//                'suriawase_config_id' => 1,
//                'suriawase_tab_id' => 1,
//                'item_name' => '年齢',
//                'item_no' => 3
//            ],
//            [
//                'suriawase_item_id' => 4,
//                'suriawase_config_id' => 1,
//                'suriawase_tab_id' => 2,
//                'item_name' => '役職',
//                'item_no' => 1
//            ],
//            [
//                'suriawase_item_id' => 5,
//                'suriawase_config_id' => 1,
//                'suriawase_tab_id' => 2,
//                'item_name' => '実役職',
//                'item_no' => 2
//            ],
//            [
//                'suriawase_item_id' => 6,
//                'suriawase_config_id' => 1,
//                'suriawase_tab_id' => 2,
//                'item_name' => 'すり合わせ実役職',
//                'item_no' => 3
//            ],
//        ]);

        Db::table('meeting_values')->insert([
//            [
//                'suriawase_value_id' => 1,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 1,
//                'personal_id' => 'S0001',
//                'value' => '中村健二'
//            ],
//            [
//                'suriawase_value_id' => 2,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 2,
//                'personal_id' => 'S0001',
//                'value' => '男'
//            ],
//            [
//                'suriawase_value_id' => 3,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 3,
//                'personal_id' => 'S0001',
//                'value' => '30'
//            ],
//            [
//                'suriawase_value_id' => 4,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 4,
//                'personal_id' => 'S0001',
//                'value' => '技師'
//            ],
//            [
//                'suriawase_value_id' => 5,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 5,
//                'personal_id' => 'S0001',
//                'value' => '一般'
//            ],
//            [
//                'suriawase_value_id' => 6,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 6,
//                'personal_id' => 'S0001',
//                'value' => 'チーフ'
//            ],
//            [
//                'suriawase_value_id' => 7,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 1,
//                'personal_id' => 'S0002',
//                'value' => '青空京子'
//            ],
//            [
//                'suriawase_value_id' => 8,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 2,
//                'personal_id' => 'S0002',
//                'value' => '女'
//            ],
//            [
//                'suriawase_value_id' => 9,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 3,
//                'personal_id' => 'S0002',
//                'value' => '25'
//            ],
//            [
//                'suriawase_value_id' => 10,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 4,
//                'personal_id' => 'S0002',
//                'value' => 'リーダー'
//            ],
//            [
//                'suriawase_value_id' => 11,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 5,
//                'personal_id' => 'S0002',
//                'value' => 'リーダー'
//            ],
//            [
//                'suriawase_value_id' => 12,
//                'suriawase_config_id' => 1,
//                'suriawase_item_id' => 6,
//                'personal_id' => 'S0002',
//                'value' => 'エッグ一般'
//            ],
            [
                'suriawase_value_id' => 13,
                'suriawase_config_id' => 1,
                'suriawase_item_id' => 1,
                'personal_id' => 'S0003',
                'value' => '青空太郎'
            ],
            [
                'suriawase_value_id' => 14,
                'suriawase_config_id' => 1,
                'suriawase_item_id' => 2,
                'personal_id' => 'S0003',
                'value' => '男'
            ],
            [
                'suriawase_value_id' => 15,
                'suriawase_config_id' => 1,
                'suriawase_item_id' => 3,
                'personal_id' => 'S0003',
                'value' => '30'
            ],
            [
                'suriawase_value_id' => 16,
                'suriawase_config_id' => 1,
                'suriawase_item_id' => 4,
                'personal_id' => 'S0003',
                'value' => '技師'
            ],
            [
                'suriawase_value_id' => 17,
                'suriawase_config_id' => 1,
                'suriawase_item_id' => 5,
                'personal_id' => 'S0003',
                'value' => '一般'
            ],
            [
                'suriawase_value_id' => 18,
                'suriawase_config_id' => 1,
                'suriawase_item_id' => 6,
                'personal_id' => 'S0003',
                'value' => 'チーフ'
            ]
        ]);
    }
}
