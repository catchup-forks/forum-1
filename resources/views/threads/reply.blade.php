<reply :attributes="{{ $reply }}" inline-template v-cloak>
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-primary btn-xs" @click="update">Save</button>
                <button class="btn btn-link btn-xs" @click="editing = false">Cancel</button>
            </div>
            <article v-else v-text="body">
                {{ $reply->body }}
            </article>
        </div>
        @can('update', $reply)
            <div class="panel-footer level">
                <button class="btn btn-default btn-xs mr-1" type="submit"
                        @click="editing = true">{{ __('Edit') }}</button>

                <form action="/replies/{{ $reply->id }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger btn-xs" type="submit">{{ __('Delete') }}</button>
                </form>
            </div>
        @endcan
    </div>
</reply>