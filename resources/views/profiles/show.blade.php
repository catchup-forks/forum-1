@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>{{ $profileUser->name }}</h1>
            <small>{{ __('Signed Up :time', ['time' => $profileUser->created_at->diffForHumans()]) }}</small>
        </div>

        <div class="row">
            @foreach ($threads as $thread)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <div class="flex">
                                <a href="#">{{ $thread->creator->name }}</a> {{ __('posted') }}: <a href="{{ route('thread', ['thread' => $thread, 'channel' => $thread->channel]) }}">{{ $thread->title }}</a>
                            </div>
                            <span>{{ $thread->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="panel-body">
                        <article>
                            {{ $thread->body }}
                        </article>
                    </div>
                </div>
            @endforeach

            {{ $threads->links() }}
        </div>
    </div>

@endsection
