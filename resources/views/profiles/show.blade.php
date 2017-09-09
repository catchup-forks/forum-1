@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <div class="level">
                <avatar-form class="mr-1" :user="{{ $profileUser }}"></avatar-form>
                <div class="flex">
                    <h1>{{ $profileUser->name }}</h1>
                    <small>{{ __('Signed Up :time', ['time' => $profileUser->created_at->diffForHumans()]) }}</small>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="row">
                <div class="col-md-8">
                    @forelse ($activitiesByDate as $date => $activities)
                        <h3 class="page-header">{{ $date }}</h3>
                        @foreach ($activities as $activity)
                            @if (view()->exists("profiles.activities.{$activity->type}"))
                                @include("profiles.activities.{$activity->type}")
                            @endif
                        @endforeach
                    @empty
                        <p>{{ __('There is no activity for this user yet.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
