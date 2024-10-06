<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        @if (Auth::user()->role->name === 'Super Admin')
            <!-- Super Admin specific content -->
        @else
            @php
                
                // Get the current time
                $currentTime = Carbon\Carbon::now()->format('H:i');
                // dd($currentTime);
                // Set the allowed check-in time (8 AM)
                $checkInTime = '08:00';
            @endphp

            <li class="nav-link">
                <a href="{{ route('employee.checkin', Auth::user()->id) }}" type="button"
                    class="btn btn-outline-primary {{ $currentTime >=$checkInTime ? '' : 'disabled' }}">
                    Check In <i class="fa fa-check"></i>
                </a>
            </li>
        @endif

        <li class="nav-link">
            <form class="form-inline my-2 my-lg-0" action="https://classicro.com.np/customer/search" type="get">
                <input type="hidden" name="_token" value="GSjHuGwYdbhPgw91wiX5pbE881R5tEpLZMsqQSjF"> <input
                    class="form-control mr-sm-2" name="username" placeholder="Username">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false" v-pre="">
                    @if (!auth()->user()->image)
                        <i class="fa fa-user"></i>
                    @else
                        <img src="{{ asset('upload/images/users/' . auth()->user()->image) }}"
                            class="img-circle elevation-2" alt="User Image" height="100%">
                    @endif
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="fas fa-user"></i>
                        {{ __('Profile') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        <i class="fas fa-arrow-right"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</nav>
