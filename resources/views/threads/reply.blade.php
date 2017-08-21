<div class="panel panel-default">
    <div id="reply-{{ $reply->id }}" class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a> {{ __('said') }}:
                {{ $reply->created_at->diffForHumans() }}
            </h5>

            <div>

                <form method="POST" action="/replies/{{ $reply->id }}/favorite">
                    {{ csrf_field() }}
                    <button class="btn btn-default" type="submit" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }}
                        {{ str_plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <article>
            {{ $reply->body }}
        </article>
    </div>
    @can('delete', $reply)
        <div class="panel-footer">
            <form action="/replies/{{ $reply->id }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger btn-xs" type="submit">Delete</button>
            </form>
        </div>
    @endcan
</div>