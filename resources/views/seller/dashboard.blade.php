@extends('home.homelayout.app')
@section('title')
   Dashboard
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('home/css/profile_panel.css') }}">

    <style>
        .position-relative {
            position: relative;
        }

        #close_alert {
            position: absolute;
            cursor: pointer;
            top: 5px;
            left: 5px;
        }

        .my-2 {
            margin: 2rem 0;
        }

        .ht-btn {
            border: none !important;
            color: white !important;
        }

        .ht-btn:hover {
            background-color: #E8D2A6 !important;
            color: #000 !important;
        }

        .single-input-item > label, .single-input-item > input {
            font-size: 14px !important;
        }
    </style>
@endsection

@section('script')

@endsection

@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-3">
                @include('seller.sidebar')
                </div>
                <div class="col-12 col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            seller Dashboard
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
