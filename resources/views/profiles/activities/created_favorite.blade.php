@component('profiles.activities.activity')

    @slot('heading')
        <div class="flex">
            {{ $activity->user->name }} <a href="{{ $activity->subject->favorited->path() }}">{{ __('favorited a reply in') }} {{ $activity->subject->favorited->thread->title }}</a>:
        </div>
        <span>
            {{ $activity->subject->created_at->diffForHumans() }}
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot

@endcomponent