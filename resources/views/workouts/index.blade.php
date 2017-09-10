@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ __('Workouts nearby') }}</strong>
                    </div>

                    <ul class="list-group">
                        @foreach($workouts as $workout)
                            <li class="list-group-item">
                                <a href="{{ route('workout.show', ['workout' => $workout]) }}">
                                    @if ($workout->tempo == null)
                                        {{ __('Unspecified') }}
                                    @else
                                        {{ $workout->km_tempo }}/km</td>
                                    @endif
                                    {{ __('pace for') }} {{ $workout->distance }} km
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                @include('workouts.partials.panel')

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
