<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeIndicator;
use App\IndicatorType;
use Response;

class IndicatorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $indicatorList = IndicatorType::orderBy('id', 'asc')->get();
        return view('pages.indicators-list')->with('indicatorList', $indicatorList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $time_start = microtime(true);
        $indicatorType = new IndicatorType([
            'indicator_name' => $request->get('name-input'),
        ]);
        $success = $indicatorType->save();
        if ($success) {
            $employees = Employee::all();
            $defaultIndicatorValue = 0;
            foreach ($employees as $key => $employee) {
                $indicators[] = array(
                    'employee_id' => $employee->id,
                    'indicator_id' => $indicatorType->id,
                    'indicator_value' => $defaultIndicatorValue,
                    'created_at' => now(),
                    'updated_at' => now(),
                );
            }
            try {
                /* Для повышения производительности добавляем все новые значения показателя одним запросом  */
                EmployeeIndicator::insert($indicators);
            }
            catch (\Exception $e) {
                $errorMessage = $e->getMessage();
                return Response::json(["При обновдении таблицы со значениями показателей возникла ошибка: $errorMessage."], 422);
            }
            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start);
            return Response::json(["Новый показатель создан за $execution_time сек."], 200);
        }
        else {
            return Response::json(['Создать новый показатель не удалось.'], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $time_start = microtime(true);
        $indicatorType = IndicatorType::find($id);
        $indicatorType->indicator_name = $request->get('name-input');
        $success = $indicatorType->save();
        if ($success) {
            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start);
            return Response::json(["Показатель успешно обновлен за $execution_time сек."], 200);
        }
        else {
            return Response::json(['Название показателя обновить не удалось.'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $time_start = microtime(true);
        $indicatorType = IndicatorType::find($id);
        $indicatorName = $indicatorType->indicator_name;
        $success = $indicatorType->delete();
        if ($success) {
            /* После удаления индикатора и его значений пересчитываем рейтинги работников */
            $indicators = EmployeeIndicator::all();
            $ratings = array();
            $ratingSum = array();
            foreach ($indicators as $indicator) {
                if (!isset($ratingSum[$indicator->employee_id])) {
                    $ratingSum[$indicator->employee_id] = 0;
                }
                $ratings[$indicator->employee_id] = array(
                    'id' => $indicator->employee_id,
                    'rating' => $ratingSum[$indicator->employee_id] += $indicator->indicator_value,
                );
            }
            /* Для повышения производительности обновляем рейтинги одним запросом  */
            $ratingUpdated = Employee::updateRatings($ratings);
            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start);
            if ($ratingUpdated['success']) {
                return Response::json(["Показатель \"$indicatorName\" успешно удален за $execution_time сек."], 200);
            }
            else {
                $errorMessage = $ratingUpdated['message'];
                return Response::json(["При обновлении таблицы возникла ошибка: $errorMessage"], 422);
            }
        }
        else {
            return Response::json(['При удалении показателя возникла ошибка.'], 422);
        }
    }
}
