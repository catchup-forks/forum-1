@component('profiles.activities.activity')

    @slot('heading')
        <div class="flex">
            <img class="mr-1 img-rounded" src="{{ $activity->subject->creator->avatar_path }}" width="40" alt="{{ $activity->subject->creator->name }}">
            <a href="{{ route('profile', ['user' => $activity->subject->creator]) }}">{{ $activity->subject->creator->name }}</a> {{ __('posted') }}: <a href="{{ route('thread', ['thread' => $activity->subject, 'channel' => $activity->subject->channel]) }}">{{ $activity->subject->title }}</a>
        </div>
        <span>
            {{ $activity->subject->created_at->diffForHumans() }}
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot

@endcomponent