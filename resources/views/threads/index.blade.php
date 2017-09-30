@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($title)
            <div class="row">
                <div class="col-xs-12">
                    <h1>{{ $title }}</h1>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-8">

                {{ $threads->links() }}

                @forelse($threads as $thread)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ $thread->path() }}">
                                        @if (auth()->check() && $thread->hasUpdatesFor(auth()->id()))
                                            <strong>{{ $thread->title }}</strong>
                                        @else
                                            {{ $thread->title }}
                                        @endif
                                    </a>
                                </h4>
                                <strong>{{ $thread->replies_count }} {{ __(str_plural('answer', $thread->replies_count)) }}</strong>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="body">{{ $thread->body }}</div>
                        </div>

                        <div class="panel-footer">
                            {{ $thread->visits }} {{ __('visits') }}
                        </div>
                    </div>
                @empty
                    <p>{{ __('There are no threads here.') }}</p>
                @endforelse

                {{ $threads->links() }}
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ __('Channels') }}</strong>
                    </div>
                    @include('channels.partials.list')
                </div>
            </div>
        </div>
    </div>
@endsection
