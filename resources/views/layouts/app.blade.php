<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/images/favicon.png">

    @if (isset($title))
        <title>{{ $title . ' - ' . config('app.name', 'Laravel') }}</title>
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
        .mt-1 {
            margin-top: 1em;
        }
        .mr-1 {
            margin-right: 1em;
        }
        .mb-1 {
            margin-bottom: 1em;
        }
        .ml-1 {
            margin-left: 1em;
        }
        .mob-100 {
            display: inline-block;
        }
        @media(max-width: 767px) {
            .mob-100 {
                width: 100%;
            }
            .xs-mt-1 {
                margin-top: 1em;
            }
            .xs-mr-1 {
                margin-right: 1em;
            }
            .xs-mb-1 {
                margin-bottom: 1em;
            }
            .xs-ml-1 {
                margin-left: 1em;
            }
        }
        .btn-facebook {
            background-color: #3B5998;
            color: #fff;
        }
        .btn-facebook:hover {
            background-color: #3B4584;
            color: #fff;
        }
        .btn-google {
            background-color: #d34836;
            color: #fff;
        }
        .btn-google:hover {
            background-color: #BF4836;
            color: #fff;
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
