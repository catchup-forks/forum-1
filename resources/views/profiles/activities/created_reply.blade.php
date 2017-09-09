@component('profiles.activities.activity')

    @slot('heading')
        <div class="flex">
            <img class="mr-1 img-rounded" src="{{ $activity->user->avatar_path }}" width="40" alt="{{ $activity->user->name }}">
            <a href="{{ route('profile', ['user' => $activity->user]) }}">{{ $activity->user->name }}</a> {{ __('replied to') }} <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>:
        </div>
        <span>
            {{ $activity->subject->created_at->diffForHumans() }}
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot

@endcomponent