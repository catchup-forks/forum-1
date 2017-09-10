<div class="text-center" style="width: 100%">
    <a href="{{ route('oauth_login', ['driver' => 'facebook']) }}" class="btn btn-facebook btn-lg">
        {{ __('Sign in with Facebook') }}
    </a>

    <a href="{{ route('oauth_login', ['driver' => 'google']) }}" class="btn btn-google btn-lg">
        {{ __('Sign in with Google') }}
    </a>
</div>