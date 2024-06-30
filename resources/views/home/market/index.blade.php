@extends('home.homelayout.app')

@section('script')
    <script type="module">


        $(document).ready(function () {

            // TimerClock(60);
            {{--GetMarket({{ $market->id }});--}}
            {{--let now = '{{ $now }}';--}}
            {{--now = new Date(now).getTime();--}}
            {{--MarketOnline({{ $market->id }}, now);--}}

        });
        let i = 0;
        let pie = 100;
        window.Echo.channel('market-status-updated')
            .listen('MarketStatusUpdated', function (e) {
                let market_page_id = "{{ $market->id }}";
                let market_id = e.market_id;
                let difference = e.difference;
                let timer = e.timer;
                let status = e.status;
                // let price_step = e.step;
                let step = 1;
                let loops = Math.round(100 / step);
                let increment = 360 / loops;
                let half = Math.round(loops / 2);
                let barColor = '#ec366b';
                let backColor = '#feeff4';
                let nextdeg;

                $('#market-difference-' + market_id).html(timer);
                $('#market-difference1-' + market_id).html(timer);
                if (market_page_id == market_id) {
                    let remain = difference % 60;
                    pie = ((100 * remain) / 60);
                    TimerClock(difference, pie, status);
                }


                if (status == 1) {
                    waiting_to_open(status, market_id);
                }
                if (status == 2) {
                    ready_to_open(status, market_id);
                }
                if (status == 3) {
                    opening(status, market_id);
                }
                if (status == 4) {
                    Quotation_1_2(status, market_id);
                }
                if (status == 5) {
                    Quotation_2_2(status, market_id);
                }
                if (status == 6) {
                    Competition(status, market_id);
                }
                if (status == 7) {
                    Close_and_show_result(status, market_id);
                }
                // if (status == 8 || status == 9) {
                //     Close_and_show_result(status, market_id);
                // }


            });


        function waiting_to_open(status, id) {
            hide_result(id);
            deactive_bid(id);
            let statusText = '<span>Waiting To Open</span>';
            let color = '#000000';
            change_market_status(status, color, statusText, id)
        }

        function ready_to_open(status, id) {
            close_bid_deposit(id);
            hide_result(id);
            deactive_bid(id);
            let statusText = '<span>Ready to open</span>';
            let color = '#1f9402';
            change_market_status(status, color, statusText, id)
        }

        function opening(status, id) {
            hide_result(id);
            close_bid_deposit(id);
            active_bid(id);
            let color = '#1f9402';
            let statusText = '<span>Opening</span>';
            change_market_status(status, color, statusText, id)
        }

        function Quotation_1_2(status, id) {
            hide_result(id);
            remove_function();
            close_bid_deposit(id);
            active_bid(id);
            let color = '#1f9402';
            let statusText = '<span>Quotation 1/2</span>';
            change_market_status(status, color, statusText, id)
        }

        function Quotation_2_2(status, id) {
            hide_result(id);
            remove_function();
            close_bid_deposit(id);
            active_bid(id);
            let color = '#1f9402';
            let statusText = '<span>Quotation 2/2</span>';
            change_market_status(status, color, statusText, id)
        }

        function Competition(status, id) {
            close_bid_deposit(id);
            // $('#bid_price-'+id).attr('onkeyup', 'step_price_competition(this,event)');
            // $('#bid_price-'+id).attr('step', step);
            remove_function();
            Competition_Bid_buttons(id);
            let color = '#1f9402';
            let statusText = '<span>Competition</span>';
            change_market_status(status, color, statusText, id)
        }

        function Stop(status, id) {
            close_bid_deposit(id);
            remove_function();
            deactive_bid(id);
            let color = '#c20000';
            let statusText = '<span>Close</span>';
            change_market_status(status, color, statusText, id);
        }

        function Close_and_show_result(status, id) {
            close_bid_deposit(id);
            remove_function();
            deactive_bid(id);
            let color = '#c20000';
            let statusText = '<span>Close</span>';
            $('#market-difference1-' + id).css({color: color})
            show_market_result(id);
            change_market_status(status, color, statusText, id);
        }

        function close_bid_deposit(id) {
            $('#bid_deposit_section-' + id).addClass('bg-inactive');
            $('#bid_deposit_section-' + id).find('input').prop('disabled', true);
        }

        function change_market_status(status, color, statusText, id) {
            let animation_main_div = $('#market-time-parent-' + id).find('.animation_main_div');
            animation_main_div.removeClass('d-none');
            animation_main_div.addClass('d-none');
            $('#previous_status-' + id).val(status);
            $('#market-' + id).css('color', color);
            $('#status-box-' + id).css('color', color);
            $('#market-difference-' + id).css('background', color);
            $('#market-status-' + id).html(statusText);
            if (status == 2 || status == 3 || status == 4 || status == 5) {
                animation_main_div.removeClass('d-none');
            }
            sales_offer_buttons(status, id);
        }

        function sales_offer_buttons(status, id) {
            // let seller_quantity = $('#seller_quantity-'+id);
            let seller_price = $('#seller_price-' + id);
            let seller_button = $('#seller_button-' + id);
            if (status == 1) {
                // seller_quantity.prop('disabled', true);
                seller_price.prop('disabled', true);
                seller_button.prop('disabled', true);
            }
            if (status == 2) {
                // seller_quantity.prop('disabled', true);
                seller_price.prop('disabled', true);
                seller_button.prop('disabled', true);
            }
            if (status == 3) {
                // seller_quantity.prop('disabled', true);
                seller_price.prop('disabled', true);
                seller_button.prop('disabled', true);
            }
            if (status == 4) {
                // seller_quantity.prop('disabled', false);
                seller_price.prop('disabled', true);
                seller_button.prop('disabled', false);
            }
            if (status == 5) {
                // seller_quantity.prop('disabled', true);
                seller_price.prop('disabled', false);
                seller_button.prop('disabled', false);
            }
            if (status == 6) {
                // seller_quantity.prop('disabled', true);
                seller_price.prop('disabled', true);
                seller_button.prop('disabled', true);
            }
            if (status == 7 || status == 8 || status == 9) {
                // seller_quantity.prop('disabled', true);
                seller_price.prop('disabled', true);
                seller_button.prop('disabled', true);
            }
        }

        window.Echo.channel('change-sales-offer')
            .listen('ChangeSaleOffer', function (e) {
                let market_id = e.market_id;
                refreshSellerTable(market_id);
                let msg = 'Seller decreased offer Price';
                let bg = 'blue';
                ShowAlert(market_id, msg, bg);
            });
        window.Echo.channel('market-setting-updated-channel')
            .listen('MarketTimeUpdated', function (e) {
                {{--GetMarket({{ $market->id }}, e.now);--}}
            });
        window.Echo.channel('new_bid_created')
            .listen('NewBidCreated', function (e) {
                let market_id = e.market_id;
                refreshBidTable(market_id);
                let msg = 'New Bid Created';
                let bg = 'green';
                ShowAlert(market_id, msg, bg);
            });

        function show_market_result(id) {
            $.ajax({
                url: "{{ route('home.get_market_bit_result') }}",
                data: {
                    id: id,
                },
                dataType: "json",
                method: "POST",
                success: function (msg) {
                    if (msg[0] == 1) {
                        let is_winner = msg[2];
                        if (is_winner == 1) {
                            show_win_modal(id);
                        }
                        $('#final_status_section_table-' + id).html(msg[1]);
                        $('#final_status_section-' + id).show();
                    } else {
                        console.log('error');
                    }
                }
            })
        }

        function hide_result(market_id) {
            $('#final_status_section-' + market_id).hide();
            $('#Winner_Modal').modal('hide');
        }

        function show_win_modal(id) {
            $('#Winner_Modal-' + id).modal('show');
            $('#Winner_Modal-' + id).removeAttr('id');
        }


    </script>
    <script>
        $(document).ready(function () {

            let width = window.innerWidth;
            if (width < 992) {
                $('.menu-des').remove();
            } else {
                $('.menu-mobile').remove();
            }
        });

        function ShowAlert(market_id, msg, bg) {
            let alertBox = $('#marketAlertBox-' + market_id);
            alertBox.text(msg);
            alertBox.css('background', bg);
            alertBox.fadeIn();
            setTimeout(function () {
                alertBox.fadeOut();
            }, 4000)
        }

        function PayBidDeposit(market_id) {
            let url = "{{ route('payment.paypal') }}";
            let user_id = {{ auth()->id() }};
            let redirect_route = "{{ route('home.bid', ['market' => ':market']) }}";
            redirect_route = redirect_route.replace(':market', market_id);

            $.ajax({
                url: url,
                data: {
                    user_id: user_id,
                    redirect_route: redirect_route,
                    market_id: market_id,
                    _token: "{{ csrf_token() }}",
                },
                method: 'post',
                success: function (data) {
                    if (data[0] == 1) {
                        window.location.href = data[1];
                    }
                }

            })
        }


        function TimerClock(seconds, pie, status) {
            $step = 1;
            $loops = Math.round(100 / $step);
            $increment = 360 / $loops;
            $half = Math.round($loops / 2);
            $barColor = '#162fa2';
            $backColor = '#feeff4';
            var num = 0;
            var sec = seconds;
            var lop = sec;
            var min = parseInt(seconds / 60);
            $('.count').text(min);
            if (min > 0) {
                $('.count').addClass('min')
            } else {
                $('.count').addClass('sec')
            }
            if (2 < status && status < 7) {
                $barColor = '#1f9402';
            }
            if (seconds < 10) {
                $barColor = '#c20000';
            }
            // console.log('sec: ', sec);
            // if (min > 1) {
            //     pie = pie + (100 / (lop / min));
            // } else {
            //     pie = pie + (100 / (lop));
            // }
            // if (pie >= 101) {
            //     pie = 1;
            // }
            num = (sec / 60).toFixed(2).slice(0, -3);
            if (num == 0) {
                $('.count').removeClass('min').addClass('sec').text(sec);
            } else {
                $('.count').removeClass('sec').addClass('min').text(num);
            }

            $i = (pie.toFixed(2).slice(0, -3)) - 1;
            if (1 < pie && pie < 3) {
                pie = 3;
            }
            console.log('pie', pie);
            if (pie < 1) {

                $nextdeg = 90 + 'deg';
                $('.clockk').css({'background-image': 'linear-gradient(' + $nextdeg + ',' + $barColor + ' 50%,transparent 50%,transparent),linear-gradient(270deg,' + $barColor + ' 50%,' + $backColor + ' 50%,' + $backColor + ')'});

            } else {
                if ($i < $half) {

                    $nextdeg = (90 + ($increment * $i)) + 'deg';
                    $('.clockk').css({'background-image': 'linear-gradient(90deg,' + $backColor + ' 50%,transparent 50%,transparent),linear-gradient(' + $nextdeg + ',' + $barColor + ' 50%,' + $backColor + ' 50%,' + $backColor + ')'});
                } else {

                    $nextdeg = (-90 + ($increment * ($i - $half))) + 'deg';
                    $('.clockk').css({'background-image': 'linear-gradient(' + $nextdeg + ',' + $barColor + ' 50%,transparent 50%,transparent),linear-gradient(270deg,' + $barColor + ' 50%,' + $backColor + ' 50%,' + $backColor + ')'});
                }
            }

            if (sec == 0) {
                $('.count').text(0);
                //$('.clockk').removeAttr('class','clockk pro-100');
                $('.clockk').removeAttr('style');
            }
            return pie;
        }

    </script>
@endsection

@section('style')
    <style>
        .commodity-title {
            padding: 10px 82px !important;
            background: #6c757d;
            color: white !important;
            margin-bottom: 0 !important;
            width: 100%;
        }

        .alert-box {
            position: fixed;
            left: 40px;
            bottom: 40px;
            background-color: red;
            width: 300px;
            height: auto;
            display: none;
            text-align: left;
            vertical-align: middle;
            padding: 12px;
            color: white;
            border-radius: 10px;
        }

        .pay-btn {
            padding: 4px 33px;
            background-color: #dbc932;
            border-radius: 0;
            color: white;
        }

        .display-none {
            display: none;
        }

        .error {
            display: none
        }

        .bid_textarea {
            width: 100%;
            height: auto;
            border: 1px solid #7e7e7e;
        }

        .bg-inactive {
            background-color: #cecaca !important;
        }

        .bid_deposit {
            width: 100%;
            height: fit-content;
            border: 1px solid black;
            background-color: #31bd31;
        }

        .bid_term_condition {
            width: 100%;
            height: fit-content;
            border: 1px solid black;
        }

        .bid_input {
            width: 100%;
            height: 50px;
            border: 1px solid black;
        }

        .text-light-blue {
            color: #162fa2;
            width: 55%;
            text-align: left !important;
        }

        .bg-blue {
            background-color: #162fa2 !important;
        }

        .justify-content-center {
            justify-content: center !important;
        }

        .align-center {
            align-items: center !important;
        }

    </style>

    {{--    /*//clockk*/--}}
    <style>
        *, :after, :before {
            box-sizing: border-box
        }

        .pull-left {
            float: left
        }

        .pull-right {
            float: right
        }

        .clearfix:after, .clearfix:before {
            content: '';
            display: table
        }

        .clearfix:after {
            clear: both;
            display: block
        }

        .clockk:before,
        .count:after {
            content: '';
            position: absolute;
        }

        .clockk-wrap {
            margin: auto;
            width: 240px;
            height: 240px;
            /*margin-top: 100px;*/
            position: relative;
            border-radius: 50px;
            /*background-color: #fff;*/
            /*box-shadow: 0 0 15px rgba(0, 0, 0, .15);*/
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .clockk {
            top: 50%;
            left: 50%;
            width: 125px;
            height: 125px;
            border-radius: 50%;
            position: absolute;
            margin-top: -90px;
            margin-left: -90px;
            background-color: #feeff4;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .clockk span {
            z-index: 999;
            color: #162fa2;
            font-size: 21px;
        }

        .clockk:before {
            /*top: 50%;*/
            /*left: 50%;*/
            width: 100px;
            height: 100px;
            /*margin-top: -60px;*/
            /*margin-left: -60px;*/
            border-radius: inherit;
            background-color: #ffffff;

            box-shadow: 0 0 15px rgba(0, 0, 0, .15), 0 0 3px rgba(255, 255, 255, .75) inset;
            /*border:1px solid rgba(255,255,255,.1);*/
        }

        .count {
            width: 100%;
            color: #fff;
            height: 100%;
            padding: 50px;
            font-size: 32px;
            font-weight: 500;
            line-height: 50px;
            position: absolute;
            text-align: center;
        }

        .count:after {
            width: 100%;
            display: block;
            font-size: 18px;
            font-weight: 300;
            line-height: 18px;
            text-align: center;
            position: relative;
        }

        .count.sec:after {
            content: 'sec'
        }

        .count.min:after {
            content: 'min'
        }

        .action {
            margin: auto;
            max-width: 200px;
        }

        .action .input {
            margin-top: 30px;
            position: relative;
        }

        .action .input-num {
            width: 100%;
            border: none;
            padding: 12px;
            border-radius: 60px;
        }

        .action .input-btn {
            top: 0;
            right: 0;
            color: #fff;
            border: none;
            border: none;
            padding: 12px;
            position: absolute;
            border-radius: 60px;
            background-color: #ec366b;
            text-transform: uppercase;
        }

        .tbl {
            display: table;
            width: 100%
        }

        .tbl .col {
            display: table-cell
        }

        #timer_section {
            margin-bottom: 100px;
        }
    </style>
    {{--    /*//clockk*/--}}
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-12 col-md-12 col-xl-4 d-flex justify-content-center align-items-end menu-des">
                <h5 class="text-center text-info text-center p-3 commodity-title">
                    {{ $market->SalesForm->commodity }}
                </h5>
            </div>
            <div class="col-12 col-md-12 col-xl-8 mb-1">
                <h5 id="status-box-{{ $market->id }}" class="text-center">
                    Step : <span id="market-status-{{ $market->id }}"></span>
                </h5>

                <div class="clockk-wrap">
                    <div class="clockk pro-0">
                        <span id="market-difference1-{{ $market->id }}">0</span>
                    </div>
                </div>

                {{--                <span id="market-difference-{{ $market->id }}" class="circle_timer">--}}

                {{--                        </span>--}}
            </div>
        </div>
        <div class="row justify-content-between">

            <div class="col-12 col-md-12 col-xl-4 mb-5">

                @include('home.market.market_info')
            </div>
            {{--            //menu_desktop--}}
            <div class="col-12 col-md-12 col-xl-8 mb-5 menu-des">
                <div class="row mb-4">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="bid_textarea">
                            <table class="table">
                                <thead class="bg-blue text-center">
                                <tr>
                                    <th class="text-white" colspan="3">Sell Order</th>
                                </tr>
                                </thead>
                                <thead class="bg-secondary">
                                <tr>
                                    <th class="text-center text-white w-50">Max
                                        Quantity( {{ $market->SalesForm->unit }} )
                                    </th>
                                    <th class="text-center text-white w-50">Price
                                        ( {{ $market->SalesForm->currency }} )
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="seller_offer_table">
                                @include('home.market.seller_table')
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <div class="bid_textarea">
                            <table class="table">
                                <thead class="bg-success text-center text-white">
                                <tr>
                                    <th class="text-white" colspan="4">Buy Order</th>
                                </tr>
                                </thead>
                                <thead class="bg-secondary">
                                <tr>
                                    <th class="text-center text-white">
                                        Bidder
                                    </th>
                                    <th class="text-center text-white">Quantity( {{ $market->SalesForm->unit }})
                                    </th>
                                    <th class="text-center text-white">Price ( {{ $market->SalesForm->currency }}
                                        )
                                    </th>

                                </tr>
                                </thead>
                                <tbody id="bidder_offer_{{ $market->id }}">
                                @include('home.market.bidder_table')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        @auth
                            @if(auth()->user()->hasRole('seller') or auth()->user()->hasRole('admin'))
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="mt-3 text-center">
                                            <label
                                                for="seller_price-{{ $market->id }}">Price( {{ $market->SalesForm->currency }}
                                                )</label>
                                            <input disabled id="seller_price-{{ $market->id }}" type="text"
                                                   class="form-control"
                                                   name="seller_quantity-{{ $market->id }}">
                                            <p id="seller_price_error" class="error_text">please enter price</p>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <button disabled id="seller_button-{{ $market->id }}"
                                                onclick="Offer({{ $market->id }})"
                                                class="btn btn-secondary pt-1 pb-1 pr-5 pl-5">Offer
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <div class="col-12  col-md-6">
                        @if(auth()->user()->hasRole('buyer') or auth()->user()->hasRole('admin'))
                            <div class="row">
                                <div class="col-12">
                                    <div id="bid_validate_error" class="alert alert-danger text-left p-2 ">

                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mt-3 text-center">
                                        <label
                                            for="bid_quantity-{{ $market->id }}">Quantity( {{ $market->SalesForm->unit }}
                                            )</label>
                                        <input disabled id="bid_quantity-{{ $market->id }}" type="text"
                                               class="form-control">
                                        <p id="bid_quantity_error" class="error_text">please enter quantity</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mt-3 text-center">
                                        <label
                                            for="bid_price-{{ $market->id }}">Price( {{ $market->SalesForm->currency }}
                                            )</label>
                                        <input disabled id="bid_price-{{ $market->id }}" class="form-control">
                                        <p id="bid_price_error" class="error_text">please enter price</p>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-3">
                                    <button id="bid_button-{{ $market->id }}" disabled onclick="Bid({{ $market->id }})"
                                            class="btn btn-secondary pt-1 pb-1 pr-5 pl-5">Bid
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-12 mt-3">
                        <div class="bid_textarea"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3 display-none" id="final_status_section-{{ $market->id }}">
                        <div class="bid_textarea">
                            <table class="table">
                                <thead class="bg-blue text-center text-white">
                                <tr>
                                    <th class="text-white" colspan="5">final Result</th>
                                </tr>
                                </thead>
                                <thead class="bg-secondary">
                                <tr>
                                    <th class="text-center text-white">Quantity( {{ $market->SalesForm->unit }})
                                    </th>
                                    <th class="text-center text-white">Price ( {{ $market->SalesForm->currency }}
                                        )
                                    </th>
                                    <th class="text-center text-white">
                                        status
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="final_status_section_table-{{ $market->id }}">
                                @include('home.market.final_status')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3">
                        @include('home.market.bid_deposit')
                    </div>
                </div>
            </div>
            {{--            //menu_mobile--}}
            @include('home.market.mobile_table')
        </div>
        <div class="row">
            <div class="col-12 mt-3">
                @include('home.market.term_condition')
            </div>
        </div>


    </div>
    <input type="hidden" id="previous_status-{{ $market->id }}" value="{{ $market->status }}">

    <div id="benchmark_info">
        @include('home.market.benchmark_info')
    </div>
    @include('home.market.winner_modal')
    <div id="marketAlertBox-{{ $market->id }}" class="alert-box">
        lorem ipsum
        lorem ipsum
        lorem ipsum
        lorem ipsum
    </div>


    <!-- Modal -->
    <div class="modal fade " id="validate_modal_{{ $market->id }}" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog validate_modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span>
                        <i class="fa fa-times-circle fa-3x text-danger"></i>
                    </span>
                    <h5 style="width: 100%" class="modal-title text-center" id="exampleModalLabel">ERROR</h5>
                </div>
                <div id="validate_modal_body_{{ $market->id }}" class="modal-body">
                    ...
                </div>
                <div class="modal-footer" style="justify-content: space-between;border: 0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Got it</button>
                </div>
            </div>
        </div>
    </div>

@endsection
