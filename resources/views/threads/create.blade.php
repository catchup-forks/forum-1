@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ __('Create A New Thread') }}</strong>
                    </div>

                    <div class="panel-body">
                        <form method="POST" action="/threads">

                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="channel_id">{{ __('Choose A Channel:') }}</label>
                                <select class="form-control" name="channel_id" id="channel_id" required>
                                    <option value="">{{ __('Choose one...') }}</option>
                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ $channel->id == old('channel_id') ? 'selected' : '' }}>{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">{{ __('Title:') }}</label>
                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ old('title') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="body">{{ __('Body:') }}</label>
                                <textarea class="form-control" rows="5" id="body"
                                          name="body" required>{{ old('body') }}</textarea>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">{{ __('Publish') }}</button>
                            </div>
                        </form>

                        @if (count($errors))
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
