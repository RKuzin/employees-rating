<?php

use Illuminate\Database\Seeder;
use App\IndicatorType;
use App\Employee;

class EmployeeIndicatorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $employees = Employee::all();
        $indicatorTypes = IndicatorType::all();
        foreach ($employees as $employee) {
            foreach ($indicatorTypes as $indicatorType) {
                $randomRating = rand(-5, 5);
                DB::table('employee_indicators')->insert([
                    [
                        'employee_id' => $employee->id,
                        'indicator_id' => $indicatorType->id,
                        'indicator_value' => $randomRating,
                    ],
                ]);
            }
        }
    }
}
