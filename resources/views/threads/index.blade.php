@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Forum Threads</div>

                    <div class="panel-body">
                        @foreach($threads as $thread)
                            <article>
                                <div class="level">
                                    <h4 class="flex"><a href="{{ $thread->path() }}">{{ $thread->title }}</a></h4>
                                    <strong>{{ $thread->replies_count }} {{ str_plural('answer', $thread->replies_count) }}</strong>
                                </div>

                                <div class="body">{{ $thread->title }}</div>
                                <hr>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
