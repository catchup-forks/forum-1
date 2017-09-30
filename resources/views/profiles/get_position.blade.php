@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>{{ __('Get your position') }}</h1>
        </div>

        <div class="row">
            <div class="col-md-8">
                {{ __('To perform this, you need to get your current locations coordinates.') }}

                <get-my-position></get-my-position>
            </div>
        </div>
    </div>

@endsection
