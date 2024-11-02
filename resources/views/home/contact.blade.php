@extends('home.homelayout.app')

@section('title')
    Arma IT
@endsection

@section('description')
    Arma Description
@endsection

@section('keywords')
    Arma Keywords
@endsection

@section('style')
    <style>
        /* Set the size of the div element that contains the map */
        #map {
            height: 400px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }

        footer {
            margin: 0 !important;
        }

        .contact-info li {
            width: 380px;
            height: 110px;
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 1px solid #2d779b;
        }
        .contact-info li .icon{
            width: 40px;
        }
        .contact-info li div{
            width: 200px;
        }

        .contact-info li p {
            font-size: 20px;
        }
        label {
            font-size: 20px;
        }

        .contact-info ul {
            margin: 0 auto;
        }
        .theme-btn{
            font-size: 13px;
            background-color: #006;
            display: block;
            width: auto;
            padding: 10px 50px;
            color: white;
            border-radius: 5px;
        }
        .contact-form{
            margin-top: 60px;
            padding: 0 50px !important;
        }
        .error_input_validate{
            font-size: 9pt;
            color: red;
        }
    </style>
@endsection


@section('script')
    <script>
        function submit() {
            $('#name_error').text('');
            $('#email_error').text('');
            $('#send_to_error').text('');
            $('#message_error').text('');
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
                    $('#email_error').text(response.responseJSON.errors.email);
                    $('#message_error').text(response.responseJSON.errors.message);
                }
            })
        }
    </script>

    <script>
        // Initialize and add the map
        function initMap() {
            const uluru = {lat: -25.344, lng: 131.031};
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 4,
                center: uluru,
            });
            const marker = new google.maps.Marker({
                position: uluru,
                map: map,
            });
        }

        window.initMap = initMap;
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly"
        defer
    ></script>

@endsection

@section('content')
    <div class="position-relative">
        <img style="width: 100%;height: auto" alt="banner"
             src="{{ imageExist(env('UPLOAD_SETTING'),$contact_us_banner) }}">
        <div style="position: absolute;top: 0;padding: 40px">
            {!! $page->banner_description !!}
        </div>
    </div>

    <!-- start contact-pg-section -->
    <section class="contact-pg-section section-padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-12 col-md-6 pt-4" style="padding-top: 80px !important;">
                    <div class="contact-form form contact-validation-active row" id="contact-form-s2">
                        <div class="col col-12 col-md-6">
                            <label for="f-name">{{ __('full name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <p class="error_input_validate" id="name_error"></p>
                        </div>
                        <div class="col col-12 col-md-6">
                            <label for="email">{{ __('email') }}</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <p class="error_input_validate" id="email_error"></p>
                        </div>
                        <div class="col col-12 col-md-12">
                            <label for="message">{{ __('message') }}</label>
                            <textarea rows="4" class="form-control" id="message" name="message"></textarea>
                            <p class="error_input_validate" id="message_error"></p>
                        </div>
                        <div class="col col-12 col-md-12 submit-btn">
                            <button type="button" onclick="submit()" class="theme-btn">{{ __('send') }}</button>
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-md-6" style="background-color: #f8f8f8;padding-top: 80px !important;">
                    <div class="contact-info row">
                        <ul class="">
                            <li>
                                <div class="icon"><i class="fa fa-map-marked fa-3x"></i></div>
                                <div>
                                    <p>
                                        <span>{{ __('Our Address') }}</span>
                                    </p>
                                    <p>
                                        <span>{{ $our_address }}</span>
                                    </p>

                                </div>
                            </li>
                            <li>
                                <div class="icon"><i class="fa fa-phone fa-3x"></i></div>
                                <div>
                                    <p>
                                        <span>{{ __('Our Number') }}</span>
                                    </p>
                                    <p>
                                        <span>{{ $our_number }}</span>
                                    </p>

                                </div>
                            </li>
                            <li>
                                <div class="icon"><i class="fa fa-envelope fa-3x"></i></div>

                                <div>
                                    <p>
                                        <span>{{ __('Our Email') }}</span>
                                    </p>
                                    <p>
                                        <span>{{ $our_email }}</span>
                                    </p>

                                </div>



                            </li>

                        </ul>
                    </div>
                </div>
            </div> <!-- end row -->


            <div class="row">
                <iframe lang="en"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2288.8411254008524!2d51.37486897704037!3d35.777584745954776!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8e07c6e16c6833%3A0x4eb8994cf0621fa8!2sQ9HF%2BRX6%2C%20Tehran%2C%20Tehran%20Province%2C%20Iran!5e0!3m2!1sen!2str!4v1730201261241!5m2!1sen!2str"
                        width="600" height="450" style="border:0;width: 100%" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>


        </div> <!-- end container -->
    </section>
    <!-- end contact-pg-section -->

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


@endsection
