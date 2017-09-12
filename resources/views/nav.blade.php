<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{ __('Workouts') }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('workout.index') }}">{{ __('Workouts') }}</a></li>
                        <li><a href="{{ route('workout.create') }}">{{ __('Create New Workout') }}</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{ __('Forum') }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/diskussion">{{ __('All Threads') }}</a></li>
                        @if (auth()->check())
                            <li><a href="/diskussion?by={{ auth()->user()->name }}">{{ __('My Threads') }}</a></li>
                        @endif
                        <li><a href="/diskussion?popular=1">{{ __('Popular All Time') }}</a></li>
                        <li><a href="/diskussion?unanswered=1">{{ __('Unanswered Threads') }}</a></li>
                    </ul>
                </li>
                <li><a href="/threads/create">{{ __('New Thread') }}</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{ __('Channels') }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($channels as $channel)
                            <li><a href="/kanal/{{ $channel->slug }}">{{ $channel->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">{{ __('Races') }} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        @foreach($races as $race)
                            <li><a href="{{ $race->slug }}">{{ $race->title }}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
            @else
                @if (auth()->user()->level > 0)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false">
                            Admin <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('pages.create') }}">{{ __('Create Page') }}</a></li>
                        </ul>
                    </li>
                @endif
                <user-notifications></user-notifications>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                       aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ route('profile', auth()->user()) }}">{{ __('My Profile') }}</a></li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
                @endif
                </ul>
        </div>
    </div>
</nav>