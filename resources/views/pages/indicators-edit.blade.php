@extends('layouts.site')

@section('title')Карточка сотрудника@endsection

@section('content')
    <div class="content page__content">
        <h3 class="content__heading">Карточка сотрудников</h3>
        <div class="employee-card container col-md-8">
            {{-- Form Starts Here --}}
            {{Form::open(['route' => ['employee.update', $employee->id], 'name' => 'employeeUpdateForm', 'class' => 'employee-form'])}}

            <div class="form-group">
                {{Form::label('full-name-input', 'Имя сотрудника:', array('class' => 'employee-form__label'))}}
                {{Form::text('full-name-input', $employee->full_name, array('class' => 'employee-form__text-input form-control'))}}
            </div>
            <div class="form-group">
                {{Form::label('name-input', 'Пол:', array('class' => 'employee-form__label'))}}
                {{Form::select('sex-select', array('0' => 'Мужской', '1' => 'Женский'), $employee->sex, ['class' => 'employee-form__select form-control']) }}
            </div>
            @foreach($indicators as $indicator)
                <div class="form-group">
                    {{Form::label('name-input', $indicator->name, array('class' => 'employee-form__label'))}}
                    {{Form::select('indicator-select['.$indicator->indicator_id.']', array('5' => '5', '4' => '4','3' => '3','2' => '2','1' => '1',
                    '0' => '0', '-1' => '-1', '-2' => '-2', '-3' => '-3', '-4' => '-4', '-5' => '-5'),
                    $indicator->indicator_value, ['class' => 'employee-form__select form-control']) }}
                </div>
            @endforeach
            <div class="form-errors"></div>
            {{Form::submit('Обновить',array('class' => 'employee-form__button btn btn-primary'))}}
            {{Form::close()}}
            {{-- Form Ends Here --}}
        </div>

    </div>
@endsection
@section('js')
    <script src="{{ mix('js/employee-edit.js') }}"></script>
@endsection