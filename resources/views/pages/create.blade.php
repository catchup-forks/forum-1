@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ __('Create Page') }}</strong>
                    </div>
                    <div class="panel-body">

                        <form method="POST" action="{{ route('pages.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="control-label">{{ __('Title') }}</label>

                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body" class="control-label">{{ __('Body') }}</label>

                                <textarea rows="16" id="body" class="form-control" name="body" required autofocus>{{ old('body') }}</textarea>

                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create Page') }}
                                </button>
                            </div>

                            <hr>

                            <div class="form-group{{ $errors->has('seo_title') ? ' has-error' : '' }}">
                                <label for="seo_title" class="control-label">{{ __('SEO title') }}</label>

                                <input id="seo_title" type="text" class="form-control" name="seo_title">

                                @if ($errors->has('seo_title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('seo_title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="seo_description" class="control-label">{{ __('SEO Description') }}</label>

                                <input id="seo_description" type="text" class="form-control" name="seo_description">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create Page') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection