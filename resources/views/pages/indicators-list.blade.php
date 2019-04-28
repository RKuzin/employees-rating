@extends('layouts.site')

@section('title')Список показателей@endsection

@section('content')
    <div class="content page__content">
        <h3 class="content__heading">Список показателей</h3>
        <div class="indicators container col-md-8">
            <table class="indicator-list table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th style="width:10%;"></th>
                    <th style="width:10%;"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($indicatorList as $key=>$indicator)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>             {{-- Form Starts Here --}}
                            {{Form::open(['route' => ['indicator.update', $indicator->id], 'name' => 'indicatorUpdateForm-'.$indicator->id, 'class' => 'indicator-form'])}}
                            {{Form::text('name-input', $indicator->indicator_name,
                        array('placeholder'=>'Введите название показателя *', 'class' => 'indicator-form__text-input form-control', 'required' => 'required'))}}
                        </td>
                        <td>
                            {{Form::submit('Обновить',array('class' => 'indicator-form__button btn btn-primary'))}}
                            {{Form::close()}}
                        </td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['indicator.delete', $indicator->id],
                            'name' => 'indicatorDeleteForm-'.$indicator->id, 'class' => 'indicator-form']) !!}
                            {!! Form::submit('Удалить', ['class' => 'indicator-form__button btn btn-danger']) !!}
                            {!! Form::close() !!}
                        </td>

                    </tr>
                @endforeach
                <tr>
                    <td>{{$indicatorList->count()+1}}</td>
                    <td>{{Form::open(['route' => ['indicator.create'], 'name' => 'indicatorCreateForm', 'class' => 'indicator-form'])}}
                        {{Form::text('name-input', null,
                    array('placeholder'=>'Введите название показателя *', 'class' => 'indicator-form__text-input form-control', 'required' => 'required'))}}</td>
                    <td>{{Form::submit('Создать',array('class' => 'indicator-form__button btn btn-success'))}}</td>
                </tr>
                </tbody>
            </table>
            <div class="indicators__messages"></div>
            <p class="indicators__text">* Поля обязательные для заполнения.</p>
            <a href="{{route('employee.index')}}" class="indicators__link">Назад к списку сотрудников</a>
        @endsection
@section('js')
            <script src="{{ mix('js/indicators.js') }}"></script>
@endsection