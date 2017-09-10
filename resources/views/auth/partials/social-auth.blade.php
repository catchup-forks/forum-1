<div class="text-center" style="width: 100%">
    <div class="mob-100 xs-mb-1">
        <a href="{{ route('oauth_login', ['driver' => 'facebook']) }}" class="btn btn-facebook btn-lg">
            {{ __('Sign in with Facebook') }}
        </a>
    </div>

    <div class="mob-100 xs-mb-1">
        <a href="{{ route('oauth_login', ['driver' => 'google']) }}" class="btn btn-google btn-lg">
            {{ __('Sign in with Google') }}
        </a>
    </div>

</div>