@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <div class="flex">
                                    <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> {{ __('posted') }}
                                    : {{ $thread->title }}
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
                        <p class="text-center">{!! __('Please <a href=:link>sign in</a> to participate in this discussion', ['link' => '"'.route('login').'"']) !!}.</p>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <p>{!!  __('This thread was created :time by :link', [
                        'time' => $thread->created_at->diffForHumans(),
                        'link' => '<a href="'.route('profile', $thread->creator->name).'">'.$thread->creator->name.'</a>'
                        ] ) !!}. {!! __('The thread has :count replies', ['count' => '<span v-html="repliesCount"></span>']) !!}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
