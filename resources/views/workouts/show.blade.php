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
                        <li class="list-group-item">
                            {{ $workout->km_tempo }}/km</td> tempo in
                            {{ $workout->distance }} km
                        </li>
                    </ul>

                    <table class="table table-striped">
                        <tr>
                            <td>{{ __("workout.start") }}:</td>
                            <td>{{ $workout->starting }}</td>
                        </tr>
                        <tr>
                            <td>{{ __("workout.attendees") }}:</td>
                            <td>{{ $workout->attendees->count() + 1 }}</td>
                        </tr>
                        <tr>
                            <td>{{ __("workout.tempo") }}:</td>
                            <td>{{ $workout->km_tempo }}/km</td>
                        </tr>
                        <tr>
                            <td>{{ __("workout.distance") }}:</td>
                            <td>{{ $workout->distance }} km</td>
                        </tr>
                        {{--<tr>
                            <td>{{ lang["workout.join"] }}</td>
                            <td>
                                <button v-if="myWorkout.id != workout.id && !workout.has_joined && user_id != workout.user_id" @click="joinWorkout(workout.id)" class="btn btn-success">
                                    {{ lang["workout.join"] }}
                                </button>
                                <button v-if="myWorkout.id != workout.id && workout.has_joined && user_id != workout.user_id" @click="leaveWorkout(workout.id)" class="btn btn-danger">
                                    {{ lang["workout.leave"] }}
                                </button>
                                <span v-if="myWorkout.id == workout.id || user_id == workout.user_id">{{ lang["workout.your_workout"] }}</span>
                                <button v-if="myWorkout.id == workout.id || user_id == workout.user_id" class="btn btn-danger" @click="deleteWorkout(workout.id)">{{ lang["delete"] }}</button>
                            </td>
                        </tr>--}}

                        @if ($workout->description != null)
                            <tr>
                                <td>{{ __("workout.description") }}:</td>
                                <td>{{ $workout->description }}</td>
                            </tr>
                        @endif

                        <tr>
                            <td>{{ __("workout.proposed_meeting_place") }}:</td>
                            <td>{{ __("workout.meeting_place_bus_station") }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ __('Last updated threads') }}</strong>
                    </div>
                    {{--@include('threads.partials.latest')--}}
                </div>
            </div>
        </div>
    </div>
@endsection
