<?php

use Illuminate\Database\Seeder;

class IndicatorTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('indicator_types')->insert([
            [
                'indicator_name' => 'Выполнение плана',
            ],
            [
                'indicator_name' => 'Творческая деятельность',
            ],
            [
                'indicator_name' => 'Участие в развитии предприятия',
            ],
            [
                'indicator_name' => 'Образовательная деятельность',
            ],
            [
                'indicator_name' => 'Руководящие навыки',
            ],
        ]);
    }
}
