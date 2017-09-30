@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                @include('auth.partials.registration-form')

                <img class="img-responsive mb-1" src="/images/MateRun_logo.png" alt="MateRun Logo">
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
