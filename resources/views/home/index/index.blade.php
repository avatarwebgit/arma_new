@extends('home.homelayout.app')

@section('script')

        <script>
            @if($UserRegistered==true)
            $(document).ready(function () {
                let UserRegistered = {{ $UserRegistered }};
                if (UserRegistered) {
                    $('#UserRegisteredModal').modal('show');
                }
            });
            @endif

            function startTime() {
                var dayOfWeek = moment().format("dddd");
                let clock = moment().format("ll  h:mm a")
                let time_now = '<h3 id="dayOfWeek">' + dayOfWeek + '</h3><span>' + clock + '</span>'
                $('#time_now').html(time_now);
                t = setTimeout(function () {
                    startTime()
                }, 500);
            }

            startTime();
        </script>

    <script type="module">

        $(document).ready(function () {

            GetMarkets();

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
        function GetMarkets(){
            $.ajax({
                url:"{{ route('home.MarketTableIndex') }}",
                data:{
                    _token:"{{ csrf_token() }}",
                },
                method:'post',
                dataType:'json',
                beforeSend:function(){
                    let loader='<div class="loader"></div>'
                    $('#market_table').html(loader);
                },
                success:function(msg){
                    let table_view=msg[1];
                    let ids=msg[2];
                    $('#market_table').html(table_view)
                    $.each(ids, function (i, val) {
                        MarketOnline(val);
                    });
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




        function slidemore(market_id) {
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
@endsection

@section('content')
<div class="modal_parent" onclick="removeImageModal()">
      <div class="modal" onclick="event.stopPropagation();">
        <img class="modal_image_11" alt="" />
      </div>
      <button class="modal_close_button" onclick="removeImageModal()">
        Close
      </button>
    </div>
    <div id="time"></div>
    @if($alert_active==1)
        <div style="background-color: {{ $alert_bg_color }} !important;height: {{ $alert_height.'px' }} !important;"
             class="d-flex align-items-center justify-content-center mb-0">
            <p style="color: {{ $alert_text_color }};font-size: {{ $alert_font_size }}px !important;margin: 0 !important;">{{ $alert_description }}</p>
        </div>
    @endif
    <div class="landing-feature container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-4 mb-3">
                <h3>
                    <span>Market: </span>

                    <span class="text-success">Open</span>
                    {{--                    @else--}}
                    {{--                        <span class="text-danger">Close</span>--}}
                    {{--                    @endif--}}
                </h3>

                <span style="font-weight: bolder">Total Trade Value:$ 210.650.800</span>
            </div>
            <div id="timer_section" class="col-12 col-md-4 d-flex justify-content-center mb-3">
                <div class="clock">
                    <div class="column">
                        <div class="timer" id="hours"></div>
                        <div class="text hour">Hour</div>
                    </div>
                    <div style="font-family:none !important" class="timer">:</div>
                    <div class="column">
                        <div class="timer" id="minutes"></div>
                        <div class="text">MIN</div>
                    </div>
                    <div style="font-family: normal !important" class="timer">:</div>
                    <div class="column">
                        <div class="timer" id="seconds"></div>
                        <div class="text">SEC</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3" id="time_now">
                <h3>{{ Carbon\Carbon::now()->format('l') }}</h3>
                <span>{{ Carbon\Carbon::now()->format('d M Y g:i A') }}</span>
            </div>
        </div>
    </div>
    <div class="landing-feature container">
        <div class="row">
            <div id="market_table" class="col-12">

            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
    <div class="landing-feature">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Here are a few reasons why <br> you should choose Crypo</h2>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/stroge.svg') }}" alt="">
                        <h3>Secure storage</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Modi quaerat, quidem ut, fugiat
                            blanditiis
                            facere</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/backup.svg') }}" alt="">
                        <h3>Protected by insurance</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Modi quaerat, quidem ut, fugiat
                            blanditiis
                            facere</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/managment.svg') }}" alt="">
                        <h3>Industry best practices</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Modi quaerat, quidem ut, fugiat
                            blanditiis
                            facere</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="landing-number">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>$657B</h2>
                    <p>Quarterly volume traded</p>
                </div>
                <div class="col-md-4">
                    <h2>100+</h2>
                    <p>Countries supported
                    </p>
                </div>
                <div class="col-md-4">
                    <h2>56+M</h2>
                    <p>Verified users
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
                        <h3>Link your bank account </h3>
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

    <div class="landing-sub">
        <div class="container">
            <div class="row">
                <div class="offset-md-1 col-md-10">
                    <div class="landing-sub-content">
                        <h2>Become part of a global community of people who have found their path to the crypto world
                            with Crypo
                        </h2>
                        <a href='signup-dark.html'>Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->

    @if($UserRegistered)
        <!-- Modal -->
        <div class="modal fade" id="UserRegisteredModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $UserRegistered_message->title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! $UserRegistered_message->text !!}
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
    @include('home.partials.footer')

@endsection
