@extends('home.homelayout.app')

@section('title')
    {{ isset($page->title)   ? $page->title : 'صفحه وجود ندارد' }}
@endsection

@section('style')
    <style>
        span {
            line-height: 9pt !important;
        }

        .red td {
            color: #c20000 !important;
        }

        .green td {
            color: green !important;
        }

        @media screen and (max-width: 768px) {
            span {
                font-size: 10pt !important;
            }

            p {
                line-height: 17px !important;
                margin: 0 !important;
            }
        }

        td, td {
            border: none !important;
            padding-left: 10px !important;
        }

        tbody td:hover {
            background: #d9d9d9;
        }

        .daily_report tr:hover {
            background: #d9d9d9 !important;
            cursor: pointer;
        }

        .daily_report tbody tr:nth-child(2n+1) {
            background: #f8f8f8;
        }

        thead td {
            color: black !important;
            font-weight: bold !important;
        }


        td {
            color: #036f88 !important;
            position: relative;
            padding-left: 10px !important;
        }

        td:before {
            content: "";
            position: absolute;
            top: 8px !important;
            left: 0 !important;
            widtd: 2px;
            height: 20px !important;
            background-color: #ffa700;
        }

        .landing-feature {
            text-align: justify !important;
        }

        label {
            font-size: 16px;
        }

        #url, #option_value {
            display: none;
        }

        .table td {
            padding: 6px 18px !important;
        }

        #help_support_section {
            background-color: #dadada;
        }

        .font-address {
            font-size: 14pt !important;
            height: 180px !important;
            position: relative;
        }

        .font-address .title::before {
            content: " ";
            display: block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: blue;
            position: absolute;
            left: 0;
            top: 9px;
        }

        .header-section {
            position: relative;
        }

        .header-section::before {
            content: " ";
            display: block;
            width: 4px;
            height: 25px;
            position: absolute;
            left: -10px;
            top: 7px;
            background-color: blue;
        }

        label {
            color: white;
        }

        .form-control {
            border-radius: 0 !important;
            height: 40px;
        }

        .send-btn {
            height: 40px;
        }

        .error_input_validate {
            font-size: 9pt;
            font-weight: bold;
            color: red;
        }

        footer {
            margin-top: 0 !important;
        }
    </style>
@endsection

@section('script')
    <script>
        function submit() {
            $('#name_error').text('');
            $('#name_error').addClass('d-none');

            $('#email_error').text('');
            $('#email_error').addClass('d-none');

            $('#send_to_error').text('');
            $('#send_to_error').addClass('d-none');

            $('#message_error').text('');
            $('#message_error').addClass('d-none');
            //
            let name = $('#name').val();
            let email = $('#email').val();
            let send_to = $('#send_to').val();
            let message = $('#message').val();
            $.ajax({
                url: "{{ route('home.contact') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: name,
                    email: email,
                    send_to: send_to,
                    message: message,
                },
                success: function (response) {
                    if (response[0] == 1) {
                        $('#exampleModal').modal('show')

                        $('#name').val('');
                        $('#email').val('');
                        $('#message').val('');

                        $('#name_error').text('');
                        $('#email_error').text('');
                        $('#send_to_error').text('');
                        $('#message_error').text('');
                    }
                },
                error: function (response) {
                    $('#name_error').text(response.responseJSON.errors.name);
                    $('#name_error').removeClass('d-none');
                    $('#email_error').text(response.responseJSON.errors.email);
                    $('#email_error').removeClass('d-none');
                    $('#message_error').text(response.responseJSON.errors.message);
                    $('#message_error').removeClass('d-none');
                }
            })
        }

        $('.more_btn').click(function () {
            let is_close = $(this).hasClass('is_close');
            let button_html = '';
            if (is_close) {
                button_html = `show less
                    <i class="fa fa-angle-up ml-3"></i>`;
                $(this).parent().find('.text_want_to_hide').slideDown(2000);
                $(this).removeClass('is_close');
            } else {
                button_html = `show more
                    <i class="fa fa-angle-down ml-3"></i>`;
                $(this).parent().find('.text_want_to_hide').slideUp(2000);
                $(this).addClass('is_close');
            }
            $(this).html(button_html);
        })

        function selectType(tag) {

            if ($(tag).val() == 'Article Update') {
                $('#url').fadeIn();
                $('#option_value').fadeIn();
            } else {
                $('#url').fadeOut();
                $('#option_value').fadeOut();
            }

        }
    </script>
@endsection



@section('content')

    {{--    <div class="btn more_btn is_close">--}}
    {{--        show more--}}
    {{--        <i class="fa fa-angle-down ml-3"></i>--}}
    {{--     </div>--}}
    @if($page==null)
        <div class="landing-feature container">
            <div class="col-12">
                <div class="alert alert-success text-center">
                    this Menu Doesn't Have A Page.Please Create A Page For this Menu
                </div>
            </div>
        </div>
    @else
        <div>
            @if($page->active_banner ==1)
                <div class="position-relative">
                    <img style="width: 100%;height: auto" alt="banner"
                         src="{{ imageExist(env('UPLOAD_BANNER_PAGE'),$page->banner) }}">
                    <div style="position: absolute;top: 0;padding: 40px">
                        {!! $page->banner_description !!}
                    </div>
                </div>
            @endif
            <div class="position-relative">
                <img style="width: 100%;height: auto" alt="banner"
                     src="{{ imageExist(env('UPLOAD_BANNER_PAGE'),$page->map) }}">
            </div>
            <div id="help_support_section" class="landing-feature ">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 id="section-heading" class="header-section">
                                Help and support
                            </h2>
                        </div>
                        @foreach($help_and_support as $item)
                            <div class="col-12 col-md-4">
                                <h5>
                                    <a href="{{ $item->link_help_modal }}">
                                        {{ $item->title_help_modal }}
                                    </a>
                                </h5>
                                <span>{{ $item->description_help_modal }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="landing-feature">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="header-section">
                                Our office locations
                            </h2>
                        </div>
                        @foreach($addresses as $item)
                            <div class="col-12 col-md-4 mb-3 font-address">
                                <div class="title">
                                    {{ $item->title_modal }}
                                </div>
                                <div>
                                    {{ $item->address_modal }}
                                </div>
                                <div>
                                    {{ $item->tel_1_modal }}
                                </div>
                                <div>
                                    {{ $item->tel_2_modal }}
                                </div>
                                <div>
                                    {{ $item->tel_3_modal }}
                                </div>

                                <div>
                                    {{ $item->email_modal }}
                                </div>
                                <div>
                                    {{ $item->email_2_modal }}
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="position-relative"
                 style="background-image: url('{{ imageExist(env('UPLOAD_BANNER_PAGE'),$page->form_bg) }}');padding: 30px 0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="col col-12 col-md-6">
                                    <label for="f-name">{{ __('full name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <p class="error_input_validate d-none" id="name_error"></p>
                                </div>
                                <div class="col col-12 col-md-6">
                                    <label for="email">{{ __('email') }}</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                    <p class="error_input_validate d-none" id="email_error"></p>
                                </div>
                                <div class="col col-12 col-md-12">
                                    <label for="message">{{ __('message') }}</label>
                                    <textarea rows="4" class="form-control" id="message" name="message"></textarea>
                                    <p class="error_input_validate d-none" id="message_error"></p>
                                </div>
                                <div class="col col-12 col-md-12">
                                    <button type="button" onclick="submit()"
                                            class="send-btn btn-info btn-block mt-2">{{ __('send') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            {!! $page->description !!}
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thank You</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success text-center">
                            Your Message was sent successfully
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection