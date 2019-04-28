<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
@yield('css')
<!-- Scripts -->
    @yield('js')
</head>
<body class="page">
@yield('content')

@section('js')

@endsection
</body>
</html>