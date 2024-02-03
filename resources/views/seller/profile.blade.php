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

        function randString() {
            var dataSet = $('#new_password').attr('data-character-set').split(',');
            var possible = '';
            if ($.inArray('a-z', dataSet) >= 0) {
                possible += 'abcdefghijklmnopqrstuvwxyz';
            }
            if ($.inArray('A-Z', dataSet) >= 0) {
                possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            }
            if ($.inArray('0-9', dataSet) >= 0) {
                possible += '0123456789';
            }
            if ($.inArray('#', dataSet) >= 0) {
                possible += '![]{}()%&*$#^<>~@|';
            }

            var text = '';
            for (var i = 0; i < 20; i++) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            $('#new_password').val(text);
        }
    </script>
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
                            @include('admin.sections.alert')
                            <div class="settings-profile">
                                <form method="POST"
                                      action="{{ route('seller.update.profile',['user'=>$user->id]) }}">
                                    @csrf
                                    @method('put')
                                    <div class="row mt-4">
                                        <div class="col-md-6 mb-2">
                                            <label for="name">Name</label>
                                            <input id="name" type="text" name="name"
                                                   class="form-control"
                                                   placeholder="Name" value="{{ $user->name }}">
                                            @error('name')
                                            <p class="input-error-validate">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="email">Email</label>
                                            <input id="email" type="text" name="email"
                                                   class="form-control"
                                                   placeholder="Email" value="{{ $user->email }}">
                                            @error('name')
                                            <p class="input-error-validate">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="company_name">Company Name</label>
                                            <input id="company_name" type="text" name="company_name"
                                                   class="form-control"
                                                   placeholder="Company Name"
                                                   value="{{ $user->company_name }}">
                                            @error('company_name')
                                            <p class="input-error-validate">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="field">Field</label>
                                            <input id="field" type="text" name="field"
                                                   class="form-control"
                                                   placeholder="Field" value="{{ $user->field }}">
                                            @error('field')
                                            <p class="input-error-validate">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="mobile_number">Mobile Number</label>
                                            <input id="mobile_number" type="text" name="mobile_number"
                                                   class="form-control"
                                                   placeholder="Mobile Number"
                                                   value="{{ $user->mobile_number }}">
                                            @error('mobile_number')
                                            <p class="input-error-validate">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 position-relative mb-3">
                                            <label for="new_password">Generate Password</label>
                                            <input name="new_password" id="new_password"
                                                   class="form-control"
                                                   data-character-set="a-z,A-Z,0-9,#">
                                            @error('new_password')
                                            <p class="input-error-validate position-absolute">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                            <button style="position:absolute;bottom: 4px;right: 15px;" onclick="randString()"
                                                    class="btn btn-info position-absolute"
                                                    type="button">
                                                Generate Password
                                            </button>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="btn btn-info btn-sm mb-2" type="submit">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
