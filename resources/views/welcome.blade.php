@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Utloggad</div>

                    <div class="panel-body">
                        {!! __(
                        'You need to <a href=:login>login</a> or <a href=:register>create an account</a> to create or participate in a workout without being logged in.',
                        ['login' => route('login'), 'register' => route('register')]
                        )  !!}
                    </div>
                </div>


                <img class="img-responsive" src="/images/MateRun_logo.png" alt="MateRun Logo">
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ __('Last updated threads') }}</strong>
                    </div>
                    @include('threads.partials.latest')
                </div>
            </div>
        </div>
    </div>
@endsection
