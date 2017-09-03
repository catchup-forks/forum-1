<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (isset($thread))
        <title>{{ $thread->title . ' - ' . config('app.name', 'Laravel') }}</title>
    @else
        <title>{{ config('app.name', 'Laravel') }}</title>
    @endif

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.forum = {!! json_encode([
            'user' => auth()->user(),
            'signedIn' => auth()->check(),
            'timezone' => config('app.timezone'),
        ]) !!}
    </script>

    <style>
        .flex {
            flex: 1;
        }
        .level {
            display: flex;
            align-items: center;
        }
        .mr-1 {
            margin-right: 1em;
        }
        [v-cloak] { display: none }
    </style>
</head>
<body>
<div id="app">

    @include('nav')

    @yield('content')

    <flash message="{{ session('flash') }}"></flash>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
