@component('profiles.activities.activity')

    @slot('heading')
        <div class="flex">
            <a href="#">{{ $activity->user->name }}</a> {{ __('replied to') }} <a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>:
        </div>
        <span>
            {{ $activity->subject->created_at->diffForHumans() }}
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot

@endcomponent