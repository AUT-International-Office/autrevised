<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    {{--npm --}}
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/jquery.js')}}"></script>

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-notify.js')}}"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/my-css.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" type="text/css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

</head>
<body style="background: #eef2f6">
    <div id="app" class="pb-5">

        <nav id="mainNabvar" class="navbar navbar-toggleable-md navbar-light bg-faded mb-3 hidden-print" style="background: #276bb0;">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
            AUT Fund
            </a>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <ul class="navbar-nav right">
                    <li class="nav-item">
                        <a href="{{ url('/homepage') }}" class="nav-link">Search</a>
                    </li>
                    @if (!Auth::guest())
                        <li class="nav-item">
                            <a href="{{ url('/addFund') }}" class="nav-link">Create Fund</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/import') }}" class="nav-link">import</a>
                        </li>
                    @endif
                </ul>
            </div>
            <ul class="navbar-nav right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ url('/login') }}">Login<span class="sr-only">(current)</span></a>
                    </li>
                @else

                    {{--<li class="nav-item dropdown">--}}
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                {{ Auth::user()->name }}
                            </a>
                        </li>
                        {{--<ul class="dropdown-menu p-2" aria-labelledby="navbarDropdownMenuLink">--}}
                            <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                            @if(Auth::user()->is_admin)
                                <li class="nav-item col-sm-8 mr-3">
                                    <a class="nav-link" href="{{url('/adminPanel')}}">Admin Panel</a>
                                </li>
                            @endif

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        {{--</ul>--}}
                    {{--</li>--}}
                @endif
            </ul>

        </nav>


        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/bootstrap.js')}}"></script>
</body>
</html>
