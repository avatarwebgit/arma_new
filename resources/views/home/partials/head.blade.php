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
    <style>
        html{
            overflow-x: hidden !important;
        }
        .page_description {
            height:300px;
            color:#000;
            overflow: hidden;
            position: relative;
            transition: all ease 3s;
            margin-bottom: 80px;
        }
        .page_description:before {
            content: '';
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            background: linear-gradient(transparent 150px, white);
        }
        .page_description2 {
            height: auto;
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
