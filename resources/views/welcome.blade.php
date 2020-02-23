<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>One piece</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <link rel="shortcut icon" href="{{asset('icons/site.png')}}" type="image/x-icon" />

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .icon {
            width: 20px;
            height: auto;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Roger
        </div>

        <div class="links">
            <h3>Email: 547605677@qq.com</h3>
            <h3>Position: Backend development engineer</h3>
            <h3><img src="{{asset('icons/blog.png')}}" class="icon"><a href="http://blog.luochenjie.com">Blog</a></h3>
{{--            <h3><img src="{{asset('icons/sweet.png')}}" class="icon"><a href="https://love.luochenjie.com">Love</a></h3>--}}
            <h3><img src="{{asset('icons/github.png')}}" class="icon"><a href="https://github.com/luocjv587">Github</a>
            </h3>
            <h3><img src="{{asset('icons/admin.png')}}" class="icon"><a href="http://www.luochenjie.com/admin">Admin</a>
            </h3>

            {{--                    <a href="https://nova.laravel.com">Nova</a>--}}
            {{--                    <a href="https://forge.laravel.com">Forge</a>--}}
            {{--                    <a href="https://vapor.laravel.com">Vapor</a>--}}
            {{--                    <a href="https://github.com/laravel/laravel">GitHub</a>--}}
        </div>
    </div>
</div>
</body>
</html>
