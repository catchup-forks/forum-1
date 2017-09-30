@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <div>
                                    <img class="mr-1 img-rounded" src="{{ $thread->creator->avatar_path }}" width="40" alt="{{ $thread->creator->name }}">
                                </div>
                                <div class="flex">
                                    <h1 style="font-size: 24px; margin: 0">{{ $thread->title }}</h1>
                                    <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                                </div>

                                @can ('delete', $thread)
                                    <form action="{{ $thread->path() }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <input type="submit" class="btn btn-default" value="{{ __('Delete') }}">
                                    </form>
                                @endcan
                            </div>
                        </div>

                        <div class="panel-body">
                            <article>
                                {{ $thread->body }}
                            </article>
                        </div>
                    </div>

                    @if (auth()->guest())
                        @foreach ($thread->replies as $reply)
                            @include('threads.reply')
                        @endforeach
                    @else
                        <replies @added="repliesCount++" @removed="repliesCount--"></replies>
                    @endif

                    @if (!auth()->check())
                        <p class="text-center">{!! __('Please <a href=:register>create account</a> or <a href=:login>sign in</a> to participate in this discussion', ['register' => '"'.route('register').'"','login' => '"'.route('login').'"']) !!}.</p>

                        @include('auth.partials.social-auth')
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <p>{!!  __('This thread was created :time by :link', [
                        'time' => $thread->created_at->diffForHumans(),
                        'link' => '<a href="'.route('profile', $thread->creator->slug).'">'.$thread->creator->name.'</a>'
                        ] ) !!}. {!! __('The thread has :count replies', ['count' => '<span v-html="repliesCount"></span>']) !!}.</p>

                            <hr>
                            <h4>{{ __('Subscribe To Thread') }}</h4>
                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" :authorized="{{ json_encode(auth()->check()) }}"></subscribe-button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
