@extends('home.homelayout.app')

@section('script')

    <script type="module">
        window.Echo.channel('market-index-table')
            .listen('MarketTableIndex', function (e) {
                let view_table = e.view_table;
                let market_values_html = e.market_values_html;
                $('#market_table').html(view_table);
                $('#market_value').html(market_values_html);
            });

        window.Echo.channel('line_header_updated')
            .listen('LIneHeaderUpdated', function (e) {
                let id = e.id;
                let line = e.line;
                let html = e.html;
                if (id ==null) {
                    if (line==1){
                        $('#scroll-container-first-div').html(html);
                    }else {
                        $('#scroll-container-first-div2').html(html);
                    }
                }else {
                    for (let i = 0; i < 10; i++) {
                        $('#header' + line + '-' + id + '-'+i).html(html);
                    }
                }
            });

        window.Echo.channel('market-index-result-channel')
            .listen('MarketIndexResult', function (e) {
                let timer = e.timer;
                let market_status = e.market_status;
                let difference = e.difference;
                $('#timer_section').html(timer);
                $('#Market_Status_Text').html(market_status);
            });

        document.addEventListener('DOMContentLoaded', function () {

            let market_open_finished_modal_exists = {{ $market_open_finished_modal_exists }};
            if (market_open_finished_modal_exists) {
                $('#market_open_finished_modal_exists').modal('show');
            }
            {{--let markets_groups =@json($markets_groups);--}}
            {{--let ids = [];--}}
            // $.each(markets_groups, function (i, markets) {
            //     $.each(markets, function (i, val) {
            //         ids.push(val.id);
            //     })
            // })
            $('#market_open_finished_modal_exists_close').click(function () {
                $('#market_open_finished_modal_exists').modal('hide');
            })
        })
        window.Echo.channel('market-setting-updated-channel')
            .listen('MarketTimeUpdated', function (e) {
                GetMarkets();
            });

        // window.Echo.channel('change-sales-offer')
        //     .listen('ChangeSaleOffer', function (e) {
        //         let market_id = e.market_id;
        //         get_market_info(market_id)
        //     });

        function Timer(diffSeconds) {
            var Hours = $('#Hours');
            var Minutes = $('#Minutes');
            var Seconds = $('#Seconds');
            // به‌روزرسانی زمان endTime با زمان فعلی

            // محاسبه زمان فعلی

            // محاسبه اختلاف زمانی بین endTime و time_now بر حسب میلی‌ثانیه

            // تبدیل اختلاف زمانی به ثانیه

            // نمایش اختلاف زمانی بین endTime و time_now به صورت دقیقه
            let timeLeft = diffSeconds;
            var days = Math.floor(timeLeft / 86400);
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
            var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
            if (hours < "10") {
                hours = "0" + hours;
            }
            if (minutes < "10") {
                minutes = "0" + minutes;
            }
            if (seconds < "10") {
                seconds = "0" + seconds;
            }
            Hours.text(hours);
            Minutes.text(minutes);
            Seconds.text(seconds);
        }

        function get_market_info(market_id) {
            let target_div = $('#market-time-' + market_id);
            let animation_main_div = target_div.find('animation_main_div');

            $.ajax({
                url: "{{ route('home.get_market_info') }}",
                dataType: "json",
                method: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    market_id: market_id,
                },
                success: function (msg) {
                    if (msg[0] === 1) {
                        let status_text = msg[1];
                        let status_color = msg[2];
                        let market_is_open = msg[3];
                        target_div.text(status_text);
                        target_div.css('color', status_color);
                    }
                }
            })
        }

        {{--var config = {--}}
        {{--    endDate: '{{ \Carbon\Carbon::parse($markets[0]->end)->format('Y-m-d') }} 17:00',--}}
        {{--    timeZone: 'UTC',--}}
        {{--    hours: $('#hours'),--}}
        {{--    minutes: $('#minutes'),--}}
        {{--    seconds: $('#seconds'),--}}
        {{--    newSubMessage: 'and should be back online in a few minutes...'--}}
        {{--};--}}






        // $(document).ready(function () {
        //     setInterval(function () {
        //         let getSeconds = new Date().getSeconds();
        //         if (getSeconds === 0) {
        //             refreshMarketTable();
        //         }
        //     }, 1000)
        // });

        function refreshMarketTable() {
            $.ajax({
                url: "{{ route('home.refreshMarketTable') }}",
                dataType: "json",
                method: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function (msg) {
                    if (msg[0] === 1) {
                        $('#market_table').html(msg[1]);
                    }
                }
            })
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }


    </script>
    <script>
        $(document).ready(function() {
            GetMarkets();
            let is_logged_in="{{ $is_logged_in }}";
            if (is_logged_in==1){
                $('#Login_two_device').modal('show');
            }
        });
        function GetMarkets() {

            $.ajax({
                url: "{{ route('home.today_market_status') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                method: 'get',
                dataType: 'json',
                beforeSend: function () {
                    let loader = '<div class="loader"></div>'
                    $('#market_table').html(loader);
                },
                success: function (msg) {
                    let table_view = msg[1];
                    let ids = msg[2];
                    let market_value = msg[3];
                    let Market_Status_Text = msg[4];
                    // let endDate = msg[5];
                    // let market_id_open = msg[6];
                    let now = msg[7];
                    $('#market_table').html(table_view);
                    $('#market_value').html(market_value);
                    // $('#Market_Status_Text').html(Market_Status_Text);
                    // $('#Market_Status_Text').html(msg[4]);

                    // makeTimer(endDate, market_id_open, now);
                }
            })
        }

        @if($show_modal==true)
        $(document).ready(function () {
            let show_modal = {{ $show_modal }};

            if (show_modal) {
                $('#AlertModal').modal('show');
            }
        });
        @endif

        function startTime() {
            var dayOfWeek = moment().tz("Europe/London").format("dddd");
            let clock = moment().tz("Europe/London").format("ll");
            let a = moment().tz("Europe/London").format("h:mm A");
            let time_now = '<h3 id="dayOfWeek">' + dayOfWeek + '</h3><span style="font-size: 12pt !important">' + clock + '</span><span class="ml-3 timer-bold" style="font-size: 14px">' + a + ' GMT</span>'
            $('#time_now').html(time_now);
            t = setTimeout(function () {
                startTime()
            }, 500);
        }

        startTime();

        function slidemore(market_id, event) {
            event.stopPropagation();
            $('#more_table_' + market_id).slideToggle();
            let svg = $('#slide_more_angle_' + market_id).find('svg');
            let hasClass = svg.hasClass('fa-angle-down');
            if (hasClass) {
                svg.removeClass('fa-angle-down');
                svg.addClass('fa-angle-up');
            } else {
                svg.removeClass('fa-angle-up');
                svg.addClass('fa-angle-down');
            }
        }
    </script>
@endsection

@section('style')
    <style>

        @media screen and (max-width: 1200px) {
            #Market_Status_Text {
                text-align: center !important;
            }

            #total_trade_value {
                text-align: center !important;
            }

            #time_now {
                text-align: center !important;
            }
        }

        #market_table {
            padding: 0 !important;
            text-align: center
        }

        .p-0 {
            padding: 0 !important;
        }

        #time_now > h3 {
            font-size: 30px;
        }

        #time_now > span {
            font-size: 13px !important;
        }

        .table_in_table span {
            text-align: left !important;
        }
    </style>
@endsection

@section('content')
    <div id="bg-mute"></div>
    <div id="clockNow" style="text-align: center;font-size:25px"></div>
    <div id="time"></div>
    @if($alert_active==1)
        <div style="background-color: {{ $alert_bg_color }} !important;height: {{ $alert_height.'px' }} !important;"
             class="d-flex align-items-center justify-content-center mb-0">
            <p style="color: {{ $alert_text_color }};font-size: {{ $alert_font_size }}px !important;margin: 0 !important;">{{ $alert_description }}</p>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-between pt-5">
            <div class="col-12 col-sm-4 p-0 text-left" style="font-size: 13px;font-weight: bold">
                <h3 id="Market_Status_Text">

                </h3>
                <div class="text-left" id="total_trade_value">
                    <span>Today Trade Value:</span>
                    <span id="market_value">0</span>
                </div>

            </div>
            <div id="timer_section" class="col-12 col-sm-4 d-flex justify-content-center mb-3 p-0 ">

            </div>
            <div class="col-12 col-sm-4 p-0 text-right" id="time_now">
                <h3>{{ Carbon\Carbon::now()->format('l') }}</h3>
                <span>{{ Carbon\Carbon::now()->format('d M Y g:i A') }}</span>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row pt-4">
            <div id="market_table" class="col-12">

            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <div class="landing-feature">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Why Armaiti MEX?</h2>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/1.png') }}" alt="">
                        <h3>Secure Transactions</h3>
                        <p>
                            With hard work and supervision, we present safe and secure transactions.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/2.jpg') }}" alt="">
                        <h3>Verified Buyers and Sellers </h3>
                        <p>verifying the identities of both buyers and sellers, ensuring that they are who they claim to
                            be.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/3.png') }}" alt="">
                        <h3>Competitive and Transparent Business</h3>
                        <p>parties have access to details of transactions and they have competition to discover the best
                            price.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="landing-number">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="counter">200</h2>
                    <p>Commodities </p>
                </div>
                <div class="col-md-3">
                    <h2>$<span class="counter">550</span>M</h2>
                    <p>Quarterly volume traded
                    </p>
                </div>
                <div class="col-md-3">
                    <h2><span class="counter">275</span>+</h2>
                    <p>Verified suppliers
                    </p>
                </div>
                <div class="col-md-3">
                    <h2><span class="counter">205</span>+</h2>
                    <p>Verified buyers
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="landing-feature landing-start">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Get started in a few steps</h2>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/user.svg') }}" alt="">
                        <span>1</span>
                        <h3>Create an account </h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/bank.svg') }}" alt="">
                        <span>
              2
            </span>
                        <h3>
                            pay the deposit
                        </h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/trade.svg') }}" alt="">
                        <span>3</span>
                        <h3>Start buying & selling</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--    <div class="landing-sub">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row">--}}
    {{--                <div class="offset-md-1 col-md-10">--}}
    {{--                    <div class="landing-sub-content">--}}
    {{--                        <h2>Become part of a global community of people who have found their path to the crypto world--}}
    {{--                            with Crypo--}}
    {{--                        </h2>--}}
    {{--                        <a href='signup-dark.html'>Get Started</a>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <!-- Button trigger modal -->

    @if($show_modal)
        <!-- Modal -->
        <div class="modal fade" id="AlertModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $modal_message->title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! $modal_message->text !!}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($market_open_finished_modal_exists)
        <!-- Modal -->
        <div class="modal fade" id="market_open_finished_modal_exists" tabindex="-1"
             aria-labelledby="market_open_finished_modal_exists_Label"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="market_open_finished_modal_exists_Label">Unfortunately</h5>
                        <button id="market_open_finished_modal_exists_close" type="button" class="close"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! $market_open_finished_modal !!}
                    </div>
                </div>
            </div>
        </div>
    @endif

        <!-- Modal -->
        <div class="modal fade" id="Login_two_device" tabindex="-1"
             aria-labelledby="market_open_finished_modal_exists_Label"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="market_open_finished_modal_exists_Label">Login Error</h5>
                    </div>
                    <div class="modal-body">
                        this user is already logged in By another Device
                        <br>
                    </div>
                </div>
            </div>
        </div>


@endsection
