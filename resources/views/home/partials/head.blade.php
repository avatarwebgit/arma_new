<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@section('meta_keywords'){{ $meta_description }}@show">
    <meta name="keywords" content="@section('meta_keywords'){{ $meta_keywords }}@show">
    <meta name="robots" content="{{ $robot_index==0 ? 'noindex,nofollow' : 'index,follow' }}"/>
    <title>
        @section('title')
            {{ $title }}
        @show
    </title>
    <link rel="icon" href="{{ imageExist(env('UPLOAD_SETTING'),$logo) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('home/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/timer.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/developer.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/font-awsome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset("vendor/cookie-consent/css/cookie-consent.css")}}">
    {{--    <meta name="viewport" content="width=1024">--}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"
          integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    @yield('style')
    @vite(['resources/sass/app.scss','resources/js/app.js'])
    <style>
        .header-img-icon .nav-link img{
            border-radius: 50% !important;
            border: 1px solid #C3C3C3;
        }
        div.dropdown-menu.show{
            width: 90% !important;
            margin-top: 17px !important;
        }
        .modal-backdrop.show{
            opacity: 0.7 !important;
        }
        #scroll-container > div {
            -moz-transform: translateX(100%);
            -webkit-transform: translateX(100%);
            transform: translateX(100%);
            -moz-animation: my-animation {{ $start_market.'s' }} linear 0s infinite;
            -webkit-animation: my-animation {{ $start_market.'s' }} linear 0s infinite;
            animation: my-animation {{ $start_market.'s' }} linear 0s infinite;
        }

        #scroll-container2 {
            background-color: #006;
        }

        #scroll-container2 > div {
            background-color: #006;
            color: white;
            -moz-transform: translateX(100%);
            -webkit-transform: translateX(100%);
            transform: translateX(100%);

            -moz-animation: my-animation 3200s linear {{ $end_market.'s' }} infinite;
            -webkit-animation: my-animation 3200s linear {{ $end_market.'s' }} infinite;
            animation: my-animation {{ $end_market.'s' }} linear 0s infinite;
        }

        .table_in_table td {
            display: flex;
            justify-content: center;
        }

        .table_in_table tr {
            display: flex;
            justify-content: space-around;
        }

        .table_in_table span {
            margin: 0 !important;
            width: 120px !important;
        }

        #market_index_table span {
            display: block;
            width: 30px;
            text-align: left;
            margin: 0 auto;
            font-size: 9pt;
        }


        #market_index_table tbody span {
            margin-left: 24px;
        }

        html {
            overflow-x: hidden !important;
        }

        .page_description {
            color: #000;
            position: relative;
            transition: all ease 3s;
            margin-bottom: 80px;
        }

        .text_want_to_hide {
            display: none;
        }

        .page_description2 {
            overflow: hidden;
            position: relative;
            transition: all ease 3s;
            margin-bottom: 80px;
            animation: all ease 3s;
        }

        .open_page_description {
            cursor: pointer;
            color: #FFB100;
        }

        .timer-bold {
            font-size: 10pt;;
            font-weight: bold;

        }

        @media screen and (min-width: 992px ) {
            #headerMenu .navbar-nav {
                align-items: center !important;
                margin-top: 25px;
            }

            .menu-mobile {
                display: none !important;
            }
        }

        @media screen and (max-width: 992px ) {
            .search_and_btns {
                flex-direction: row-reverse !important;
                padding: 28px 28px 28px 15px !important;
            }

            .menu-des {
                display: none !important;
            }
        }

        .text-danger {
            color: #c20000 !important;
        }

        .password-eye-icon {
            position: absolute;
            right: 24px;
            bottom: 5px
        }
        .dropdown-menu::before{
            left: 0 !important;
            right: 0 !important;
            margin: auto;
        }
        .profile-nav{
            padding: 0 !important;
        }
        .dropdown-body{
            padding: 0 !important;
        }
        .dropdown-header{
            border: none !important;
        }
    </style>
</head>
