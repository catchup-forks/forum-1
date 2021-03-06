<div>
    <div class="panel panel-default">
        <div id="reply-{{ $reply->id }}" class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <img class="mr-1 img-rounded" src="{{ $reply->owner->avatar_path }}" width="40" alt="{{ $reply->owner->name }}">
                    <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a> {{ __('said') }}:
                    {{ $reply->created_at->diffForHumans() }}
                </h5>

                @if (auth()->check())
                    <div>
                        <favorite :reply="{{ $reply }}" authorized="true"></favorite>
                    </div>
                @else
                    <div>
                        <favorite :reply="{{ $reply }}"></favorite>
                    </div>
                @endif
            </div>
        </div>
        <div class="panel-body">
            @can('update', $reply)
                <div v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>
                    <button class="btn btn-primary btn-xs" @click="update">Save</button>
                    <button class="btn btn-link btn-xs" @click="editing = false">Cancel</button>
                </div>
            @endcan
            <article>
                {{ $reply->body }}
            </article>
        </div>
        @can('update', $reply)
            <div class="panel-footer level">
                <button class="btn btn-default btn-xs mr-1" type="submit"
                        @click="editing = true">{{ __('Edit') }}</button>
                <button class="btn btn-danger btn-xs" type="submit" @click="destroy">{{ __('Delete') }}</button>
            </div>
        @endcan
    </div>
</div>