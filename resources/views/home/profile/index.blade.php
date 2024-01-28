@extends('home.homelayout.app')
@section('title')
Profile
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
    <script>
        $('.mobile-menu-toggle').click(function () {
            $('.loaded').addClass('mmenu-active');
        })
        $('.mobile-menu-close').click(function () {
            $('.loaded').removeClass('mmenu-active');
        })
        $('div#categories > ul.mobile-menu > li > a').append('<span class="toggle-btn"> </span>');
        $('div#categories > ul.mobile-menu > li > a > span.toggle-btn').click(function (e) {
            e.preventDefault();
            $(this).parent().next().slideToggle(300).parent().toggleClass("show");
        })
        // Show File Name
        $('#profile_image').change(function () {
            //get the file name
            let fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });
        $('#close_alert').click(function () {
            $(this).parent().slideUp();
        })
        $('#mobile_menu_nav').click(function () {
            $('#icon-panel').toggleClass('negative');
            $('#icon-panel').toggleClass('positive');
            $('.negative').html('-');
            $('.positive').html('+');
        })
    </script>
@endsection

@section('content')

    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">

               @include('home.profile.sidebar')
                <div class="col-md-12 col-lg-9">
                    @include('admin.sections.alert')
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="settings-profile" role="tabpanel" aria-labelledby="settings-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">General Information</h5>
                                    <div class="settings-profile">
                                        <form method="post" action="{{route('seller.update.profile',['user'=>$user->id])}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-row mt-4">
                                                <div class="col-md-6">
                                                    <label for="formFirst">Name</label>
                                                    <input value="{{$user->name}}" name="name" id="formFirst" type="text" class="form-control" placeholder="First name">
                                                </div>

                                                <div class="col-md-12">
                                                    <input type="submit" value="Update">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Security Information</h5>
                                    <div class="settings-profile">
                                        <form method="post" action="{{route('seller.update.password',['user'=>$user->id])}}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <label for="newPass">New password</label>
                                                    <input name="password" id="newPass" type="text" class="form-control" placeholder="Enter new password">
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="submit" value="Update">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="settings-wallet" role="tabpanel" aria-labelledby="settings-wallet-tab">
                            <div class="wallet">
                                <div class="row">

                                    <div class="col-md-12 col-lg-12">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="coinBTC" role="tabpanel">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Latest Transactions</h5>
                                                        <div class="wallet-history">
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th>type</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                    <th>Amount</th>
                                                                    <th>Description</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    @foreach($wallets as $item)
                                                                        <td>{{$item->type}}</td>
                                                                        <td>{{$item->created_at->format('Y/m/d')}}</td>
                                                                        <td>{{$item->status}}</td>
                                                                        <td>{{$item->amount}}</td>
                                                                        <td>{{$item->description}}</td>
                                                                    @endforeach

                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Notifications</h5>
                                    <div class="settings-notification">
                                        <ul>
                                            <li>
                                                <div class="notification-info">
                                                    <p>Update price</p>
                                                    <span>Get the update price in your dashboard</span>
                                                </div>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="notification1">
                                                    <label class="custom-control-label" for="notification1"></label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="notification-info">
                                                    <p>2FA</p>
                                                    <span>Unable two factor authentication service</span>
                                                </div>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="notification2" checked="">
                                                    <label class="custom-control-label" for="notification2"></label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="notification-info">
                                                    <p>Latest news</p>
                                                    <span>Get the latest news in your mail</span>
                                                </div>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="notification3">
                                                    <label class="custom-control-label" for="notification3"></label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="notification-info">
                                                    <p>Email Service</p>
                                                    <span>Get security code in your mail</span>
                                                </div>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="notification4" checked="">
                                                    <label class="custom-control-label" for="notification4"></label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="notification-info">
                                                    <p>Phone Notify</p>
                                                    <span>Get transition notification in your phone </span>
                                                </div>
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="notification5" checked="">
                                                    <label class="custom-control-label" for="notification5"></label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card settings-profile">
                                <div class="card-body">
                                    <h5 class="card-title">Create API Key</h5>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label for="generateKey">Generate key name</label>
                                            <input id="generateKey" type="text" class="form-control" placeholder="Enter your key name">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="rewritePassword">Confirm password</label>
                                            <input id="rewritePassword" type="password" class="form-control" placeholder="Confirm your password">
                                        </div>
                                        <div class="col-md-12">
                                            <input type="submit" value="Create API key">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Your API Keys</h5>
                                    <div class="wallet-history">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Key</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>zRmWVcrAZ1C0RZkFMu7K5v0KWC9jUJLt</td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="apiStatus1" checked="">
                                                        <label class="custom-control-label" for="apiStatus1"></label>
                                                    </div>
                                                </td>
                                                <td><i class="icon ion-md-trash"></i></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Rv5dgnKdmVPyHwxeExBYz8uFwYQz3Jvg</td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="apiStatus2">
                                                        <label class="custom-control-label" for="apiStatus2"></label>
                                                    </div>
                                                </td>
                                                <td><i class="icon ion-md-trash"></i></td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>VxEYIs1HwgmtKTUMA4aknjSEjjePZIWu</td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="apiStatus3">
                                                        <label class="custom-control-label" for="apiStatus3"></label>
                                                    </div>
                                                </td>
                                                <td><i class="icon ion-md-trash"></i></td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>M01DueJ4x3awI1SSLGT3CP1EeLSnqt8o</td>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="apiStatus4">
                                                        <label class="custom-control-label" for="apiStatus4"></label>
                                                    </div>
                                                </td>
                                                <td><i class="icon ion-md-trash"></i></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
