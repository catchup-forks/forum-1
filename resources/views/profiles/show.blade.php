@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>{{ $profileUser->name }}</h1>
            <small>{{ __('Signed Up :time', ['time' => $profileUser->created_at->diffForHumans()]) }}</small>
        </div>

        <div class="row">
            @foreach ($activitiesByDate as $date => $activities)
                <h3 class="page-header">{{ $date }}</h3>
                @foreach ($activities as $activity)
                    @include("profiles.activities.{$activity->type}")
                @endforeach
            @endforeach

        </div>
    </div>

@endsection
