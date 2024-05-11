<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@section('meta_keywords'){{ $meta_description }}@show">
    <meta name="keywords" content="@section('meta_keywords'){{ $meta_keywords }}@show">
    <meta name="robots" content="{{ $robot_index==0 ? 'noindex,nofollow' : 'index,follow' }}" />
    <title>
        @section('title')
            {{ $title }}
        @show
    </title>
    <link rel="icon" href="{{ imageExist(env('SETTING_UPLOAD_PATH'),$fav_icon) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('home/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/timer.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/developer.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/font-awsome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset("vendor/cookie-consent/css/cookie-consent.css")}}">
{{--    <meta name="viewport" content="width=1024">--}}
    <style>
        html{
            overflow-x: hidden !important;
        }
        .page_description {
            color:#000;
            position: relative;
            transition: all ease 3s;
            margin-bottom: 80px;
        }
        .text_want_to_hide{
            display: none;
        }
        .page_description2 {
            overflow: hidden;
            position: relative;
            transition: all ease 3s;
            margin-bottom: 80px;
            animation: all ease 3s;
        }
        .open_page_description{
            cursor: pointer;
            color: #FFB100;
        }
    </style>
    @yield('style')
    @vite(['resources/sass/app.scss','resources/js/app.js'])
</head>
