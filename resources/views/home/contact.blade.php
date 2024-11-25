@extends('home.homelayout.app')

@section('title')
    {{ isset($page->title)   ? $page->title : 'صفحه وجود ندارد' }}
@endsection

@section('style')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <style>
/*         span {
            line-height: 9pt !important;
        } */

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
            /*content: " ";*/
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
            padding: 2px 30px;
            background: #006;
            border: 1px solid #006;
            color: white;
            border-radius: 2.7rem;
    background-color: #33beee !important;
    background-image: none;
    border: 0;
    padding: 0px 15px !important;
    height: 45px;
              font-family: "Merriweather", serif !important;
    width: 100%;
            margin-top:5px;
    color: #fff !important;
    /* font-family: var(--merriweather); */
    font-size: 1.6rem;
    box-shadow: none;
        }

        .error_input_validate {
            font-size: 9pt;
            font-weight: bold;
            color: red;
        }

        footer {
            margin-top: 0 !important;
        }


                .contact-form-section input::placeholder,.contact-form-section textarea::placeholder{
   color:#000 !important;
            font-weight:bold !important;
                    font-size:18px !important;
                      font-family: "Merriweather", serif !important;
        }

        .contact-form-section input{
padding: 30px 10px !important;
            font-family: "Merriweather", serif !important;
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
            {{--            <div class="position-relative">--}}
            {{--                <img style="width: 100%;height: auto" alt="banner"--}}
            {{--                     src="{{ imageExist(env('UPLOAD_BANNER_PAGE'),$page->map) }}">--}}
            {{--            </div>--}}
            @if(count($help_and_support)>0)
            <div id="help_support_section" class="landing-feature ">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 id="section-heading" class="header-section">
                                Help and support
                            </h2>
                        </div>

                        @foreach($help_and_support as $k=>$item)
                            <div class="col-12 col-md-6" style="padding-right: 60px">
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
            @endif
            <div style="margin-top: 40px;margin-bottom:40px">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="header-section">
                                Our Offices
                            </h2>
                        </div>
                        @foreach($addresses as $item)
                            <div class="col-12 col-md-4 font-address">
                                <div style="padding-right: 20px">
                                    <div>
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
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="position-relative"
                 style="background-image: url('{{ imageExist(env('UPLOAD_BANNER_PAGE'),$page->form_bg) }}');padding: 120px 0">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row contact-form-section">
                                <div class="col col-12 col-md-6">
<!--                                     <label for="f-name">{{ __('Company/Name') }}</label> -->
                                    <input type="text" placeholder="{{ __('Company/Name') }}" class="form-control" id="name" name="name" required>
                                    <p class="error_input_validate d-none" id="name_error"></p>
                                </div>
                            
                                <div class="col col-12 col-md-6 ">
<!--                                     <label for="email">{{ __('Email') }}</label> -->
                                    <input placeholder="{{ __('Email') }}" class="form-control" id="email" name="email">
                                    <p class="error_input_validate d-none" id="email_error"></p>
                                </div>
                                <div class="col col-12 col-md-12 mt-3">
<!--                                     <label for="message">{{ __('Message') }}</label> -->
                                    <textarea placeholder="{{ __('Message') }}" rows="4" class="form-control" id="message" name="message"></textarea>
                                    <p class="error_input_validate d-none" id="message_error"></p>
                                </div>
                                <div class="col col-12 col-md-12 mt-3">
                                    <button type="button" onclick="submit()"
                                            class="send-btn mt-2">{{ __('Send') }}</button>
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
