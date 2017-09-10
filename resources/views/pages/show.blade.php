@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>{{ $page->title }}</h1>

                {!! $page->body !!}
            </div>
            @if (!auth()->check())
                <div class="col-md-4">
                    @include('auth.partials.social-auth')
                </div>
            @endif
        </div>
    </div>
@endsection