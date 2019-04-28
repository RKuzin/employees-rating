@extends('layouts.site')

@section('title')Рейтинг сотрудников@endsection

@section('content')
    <div class="content page__content">
        <h3 class="content__heading">Рейтинг сотрудников</h3>
        @php
            $time_start = microtime(true);
            $ratingPosition = 1;
        @endphp
            <table class="employee-rating content__table">
                <thead class="employee-rating__header">
                    <tr class="employee-rating__row">
                        <td class="employee-rating__header-cell employee-rating__header-cell_id">№ п/п</td>
                        <td class="employee-rating__header-cell employee-rating__header-cell_full-name">Имя</td>
                        <td class="employee-rating__header-cell employee-rating__header-cell_rating-points">Сумма баллов
                        </td>
                        <td class="employee-rating__header-cell employee-rating__header-cell_rating-position">Место</td>
                    </tr>
                </thead>
                <tbody class="employee-rating__body">
                @foreach($employeeList as $key=>$employee)
                    <tr class="employee-rating__row">
                        <td class="employee-rating__cell employee-rating__cell_id">{!! $key+1 !!}</td>
                        <td class="employee-rating__cell employee-rating__cell_full-name">
                            <a href="{{route('employee.edit', $employee['id'])}}" class="employee-rating__link">{!! $employee['full_name'] !!}</a>
                        </td>
                        <td class="employee-rating__cell employee-rating__cell_rating-points">{!! $employee['rating'] !!}</td>
                        <td class="employee-rating__cell employee-rating__cell_rating-position">{!! $employee['rating_possition'] !!}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        @php
            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start);
        @endphp
        <p class="content__text"><b>Время вывода таблицы: </b>{!! $execution_time !!} сек.</p>

    </div>
@endsection