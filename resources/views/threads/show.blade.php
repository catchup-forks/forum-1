@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->creator->name }}</a> {{ __('posted') }}: {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                        <article>
                            {{ $thread->body }}
                        </article>
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @if (auth()->check())
                    <form method="POST"
                          action="{{ route('reply_to_thead', ['channel_id' => $thread->channel->id, 'thread' => $thread->id]) }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control"
                                      placeholder="Have something to say?"></textarea>
                        </div>

                        <button type="submit" class="btn btn-default">{{ __('Post') }}</button>
                    </form>
                @else
                    <p class="text-center">{!! __('Please sign in to participate in this discussion.', ['link' => route('login')]) !!}
                @endif
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <p>{!!  __('This thread was created by', [
                        'time' => $thread->created_at->diffForHumans(),
                        'link' => '<a href="#">'.$thread->creator->name.'</a>'
                        ] ) !!}. {{ __('The thread has replies', ['count' => $thread->replies_count]) }}.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
