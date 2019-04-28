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
    public function index()
    {
        $indicatorList = IndicatorType::orderBy('id', 'asc')->get();
        return view('pages.indicators-list')->with('indicatorList', $indicatorList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $indicatorType = new IndicatorType([
            'indicator_name' => $request->get('name-input'),
        ]);

        $success = $indicatorType->save();
        if ($success) {
            $employees = Employee::all();
            $defaultIndicatorValue = 0;
            foreach ($employees as $key => $employee) {
                $indicator = new EmployeeIndicator([
                    'employee_id' => $employee->id,
                    'indicator_id' => $indicatorType->id,
                    'indicator_value' => $defaultIndicatorValue,
                ]);
                $indicatorCreated = $indicator->save();
                if (!$indicatorCreated){
                    return Response::json(['Возникла ошибка при обновлении таблицы показателей.'], 422);
                }
            }
            return Response::json(['Новый показатель создан.'], 200);
        } else {
            return Response::json(['Создать новый показатель не удалось.'], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $indicatorType = IndicatorType::find($id);
        $indicatorType->indicator_name = $request->get('name-input');
        $success = $indicatorType->save();
        if ($success) {
            return Response::json(['Показатель успешно обновлен.'], 200);
        } else {
            return Response::json(['Название показателя обновить не удалось.'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $indicatorType = IndicatorType::find($id);
        $indicatorName = $indicatorType->indicator_name;
        $success = $indicatorType->delete();
        if ($success) {
            $employees = Employee::all();
            foreach ($employees as $employee) {
                $rating = $employee->indicators->sum('indicator_value');
                $employee->rating = $rating;
                $employee->save();
                $ratingUpdated = $employee->save();
                if (!$ratingUpdated){
                    return Response::json(['Возникла ошибка при обновлении рейтинга сотрудника.'], 422);
                }
            }
            return Response::json(["Показатель $indicatorName успешно удален."], 200);
        } else {
            return Response::json(['При удалении показателя возникла ошибка.'], 422);
        }
    }
}
