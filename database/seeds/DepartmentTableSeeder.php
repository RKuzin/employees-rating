<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'department_name' => 'Отдел 1',
            ],
            [
                'department_name' => 'Отдел 2',
            ],
            [
                'department_name' => 'Отдел 3',
            ],
            [
                'department_name' => 'Отдел 4',
            ],
            [
                'department_name' => 'Отдел 5',
            ],
            [
                'department_name' => 'Отдел 6',
            ],
        ]);
    }
}
