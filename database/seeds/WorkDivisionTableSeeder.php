<?php

use Illuminate\Database\Seeder;

class WorkDivisionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_division')->insert([
            ['division_name' => '通常'],
            ['division_name' => '有休'],
            ['division_name' => '半休'],
            ['division_name' => '欠勤'],
        ]);
    }
}
