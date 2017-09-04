@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
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
                    </div>
                @empty
                    <p>{{ __('There are no threads here.') }}</p>
                @endforelse

                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
