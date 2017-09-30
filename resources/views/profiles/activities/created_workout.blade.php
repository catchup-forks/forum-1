@component('profiles.activities.activity')

    @slot('heading')
        <div class="flex">
            <img class="mr-1 img-rounded" src="{{ $activity->subject->creator->avatar_path }}" width="40" alt="{{ $activity->subject->creator->name }}">
            <a href="{{ route('profile', ['user' => $activity->subject->creator]) }}">{{ $activity->subject->creator->name }}</a> {{ __('posted a workout') }}
        </div>
        <span>
            {{ $activity->subject->created_at->diffForHumans() }}
        </span>
    @endslot

    @slot('body')
        {{ __('Am going to run') }}
        {{ $activity->subject->distance }} km
        {{ __('in a tempo of') }}
        {{ $activity->subject->km_tempo }}/km {{ __('on') }}
        {{ $activity->subject->starting }}
    @endslot

@endcomponent