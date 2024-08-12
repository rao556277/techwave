@section('top_nav')
    <nav class="navbar navbar-expand-md navbar-dark bg-[#2A3F54] shadow-sm">
        <div class="container">
            <a class="navbar-brand text-dark"  href="{{ url('/') }}">
                Techwave
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item text-black-50">
                            <a class="login" href="">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item text-black-50">
                            <a class="/" href="">{{ __('Register') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown text-black-50">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-black-50" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item text-black-50" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
@endsection
