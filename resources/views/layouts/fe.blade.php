<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
    <title>Document</title>
    <style>
        a {
            text-decoration: none;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between">
            <div>
                <p>Relipa Portal</p>
            </div>
            <div class="d-flex">
                <div>WelCome<a href="{{route('user.profile.index')}}">
                        @php
                        echo Auth::user()->full_name;
                        @endphp
                        | </a></div>
                @if (Route::has('login.user.index'))
                <div class="nav-item">
                    @auth

                    <form action="{{route('logout.put')}}" method="post">
                        @method('put')
                        @csrf
                       <button style="border: none; background-color: white; color: #0a97e0;">Logout</button>
                    </form>

                    @else
                    <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
                @endif
            </div>
        </div>
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12 d-flex m">
                <div><a href="{{route('user.notification.index')}}">Home |</a></div>
                <div><a href="{{route('user.timesheet.index')}}">Time Sheet |</a></div>
                <div><a href="{{route('user.r-point.index')}}">Point</a></div>
            </div>
        </div>
        @yield('content')
    </div>
</body>
<!-- JavaScript Bundle with Popper -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
@yield('scripts')
</html>