<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\EmployeeIndicator;
use Response;
use Validator;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        $employeeList = Employee::orderBy('rating', 'desc')->orderBy('full_name', 'ASC')->get();
        $prevRating = $employeeList[0]['rating'];
        $employeeList[0]['rating_possition'] = 1;
        $ratingPos = 1;
        foreach ($employeeList as $key => $employee) {
            if ($key > 0) {
                if ($employee['rating'] != $prevRating) {
                    $ratingPos++;
                }
                $prevRating = $employee['rating'];
                $employee['rating_possition'] = $ratingPos;
            }
        }
        return view('pages.employees-rating')->with('employeeList', $employeeList);
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
        //
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
    public function edit(Request $request, $id) {
        $employee = Employee::find($id);
        $indicators = $employee->indicators;
        foreach ($indicators as $indicator) {
            $indicator['name'] = $indicator->name['indicator_name'];
        }
        return view('pages.employee-edit')->with('employee', $employee)->with('indicators', $indicators);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $employee = Employee::find($id);
        $employee->full_name = $request->get('full-name-input');
        $employee->sex = $request->get('sex-select');
        $formIndicators = $request->get('indicator-select');

        foreach ($formIndicators as $key => $formIndicator) {
            $indicator = EmployeeIndicator::where('employee_id', $id)->where('indicator_id', $key)->firstOrFail();
            $indicator->indicator_value = $formIndicator;
            $indicatorUpdated = $indicator->save();
            If (!$indicatorUpdated) {
                return Response::json(['Возникла ошибка при обновлении таблицы показателей.'], 422);
            }
        }
        $employee->rating = $employee->indicators->sum('indicator_value');
        $success = $employee->save();
        if ($success) {
            return Response::json(['Карточка работника успешно обновлена.'], 200);
        } else {
            return Response::json(['Карточку работника обновить не удалось.'], 422);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
