@component('profiles.activities.activity')

    @slot('heading')
        <div class="flex">
            <a href="#">{{ $activity->subject->creator->name }}</a> {{ __('posted') }}: <a href="{{ route('thread', ['thread' => $activity->subject, 'channel' => $activity->subject->channel]) }}">{{ $activity->subject->title }}</a>
        </div>
        <span>
            {{ $activity->subject->created_at->diffForHumans() }}
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot

@endcomponent