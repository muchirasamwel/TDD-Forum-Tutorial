<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <li class="m-3">
                    <a href="/threads/create"> New Thread</a>
                </li>
                <li class="m-3">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Threads
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <a class="dropdown-item" href="/threads">All Threads</a>
                            <a class="dropdown-item" href="/threads?popular=1">Popular Threads</a>
                            @if(auth()->check())
                                <a class="dropdown-item" href="/threads?by= {{auth()->user()->name}}">My Threads</a>
                            @endif
                        </div>
                    </div>

                </li>
                <li>
                    <div class="dropdown m-3">
                        <a href="#" class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            Channels
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            @foreach($channels as $channel)
                                <a class="dropdown-item" href="/threads/{{$channel->slug}}">{{$channel->name}}</a>
                            @endforeach
                        </div>
                    </div>
                </li>

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        <a  class="dropdown-item" href="{{ route('profile', Auth::user()) }}">My Profile</a>

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
