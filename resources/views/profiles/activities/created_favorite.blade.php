@component('profiles.activities.activity')

    @slot('heading')
        <div class="flex">
            <a href="{{ route('profile', ['user' => $activity->user]) }}">{{ $activity->user->name }}</a> {{ __('favorited a reply in') }} <a href="{{ $activity->subject->favorited->path() }}">{{ $activity->subject->favorited->thread->title }}</a>:
        </div>
        <span>
            {{ $activity->subject->created_at->diffForHumans() }}
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot

@endcomponent