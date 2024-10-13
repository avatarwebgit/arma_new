@extends('admin.layouts.main')
@section('title', __('Dashboard'))
@section('content')
    <div class="row g-5 g-xl-8">
        @include('admin.dashboard.profile')
        @include('admin.dashboard.markets')
        @include('admin.dashboard.settings')
        @include('admin.dashboard.market_chart')
        @include('admin.dashboard.online_market')
        {{--        @include('admin.dashboard.users')--}}
        {{--        @include('admin.dashboard.inquiries')--}}
        {{--        @include('admin.dashboard.sales_order')--}}

    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/cssfamily=Inter:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('metronik/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('metronik/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('metronik/assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('metronik/assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .button-dashboard {
            border: 1px solid #CCCCCC;
            padding: 5px 10px;
            border-radius: 10px;
        }

        .mr10 {
            margin-right: 10px;
        }

        .dash-content {
            background-color: white;
        }

        .text-white {
            color: white !important;
        }

        .item-dashboard {
            text-align: center;
            font-size: 18px;
            border-radius: 5px;
            background: #fff;
            height: 80px;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        .bg-primary {
            background-color: red !important;
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
            width: 240px;
            height: 150px;
            /*margin-top: 100px;*/
            position: relative;
            border-radius: 50px;
            /*background-color: #fff;*/
            /*box-shadow: 0 0 15px rgba(0, 0, 0, .15);*/
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 2px auto 10px;
        }

        .clockk {
            left: 0;
            right: 0;
            top: 5px;
            margin: auto !important;
            width: 125px;
            height: 125px;
            border-radius: 50%;
            position: absolute;
            background-color: #feeff4;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .clockk span {
            z-index: 999;
            font-size: 20px !important;
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

        .timer-clock .timer {
            font-size: 26px !important;
        }

        .timer-clock .text {
            font-size: 11px !important;
            margin-top: 5px !important;
        }
    </style>
    {{--    /*//clockk*/--}}
@endpush
@push('script')
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('metronik/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('metronik/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="{{ asset('metronik/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <script src="{{ asset('metronik/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Vendors Javascript-->
    <!--begin::سفارشی Javascript(used for this page only)-->
    <script src="{{ asset('metronika/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('metronik/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('metronik/assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('metronik/assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('metronik/assets/js/custom/utilities/modals/new-card.js') }}"></script>
    <script src="{{ asset('metronik/assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('metronik/assets/js/custom/utilities/modals/users-search.js') }}"></script>
    <script>
        var initMixedWidget10 = function () {
            var charts = document.querySelectorAll('.mixed-widget-10-chart');

            var color;
            var height;
            var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
            var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
            var baseLightColor;
            var secondaryColor = KTUtil.getCssVariableValue('--bs-gray-300');
            var baseColor;
            var options;
            var chart;

            [].slice.call(charts).map(function (element) {
                color = element.getAttribute("data-kt-color");
                height = parseInt(KTUtil.css(element, 'height'));
                baseColor = KTUtil.getCssVariableValue('--bs-' + color);

                options = {
                    series: [{
                        name: 'Bid',
                        data: @json($bids)
                    }, {
                        name: 'Bid',
                        data: @json($bids)
                    }],
                    chart: {
                        fontFamily: 'inherit',
                        type: 'bar',
                        height: height,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: ['50%'],
                            borderRadius: 4
                        },
                    },
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: @json($commodities),
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        y: 0,
                        offsetX: 0,
                        offsetY: 0,
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px'
                            }
                        }
                    },
                    fill: {
                        type: 'solid'
                    },
                    states: {
                        normal: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: false,
                            filter: {
                                type: 'none',
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: '12px'
                        },
                        y: {
                            formatter: function (val) {
                                return  val;
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor],
                    grid: {
                        padding: {
                            top: 10
                        },
                        borderColor: borderColor,
                        strokeDashArray: 4,
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    }
                };

                chart = new ApexCharts(element, options);
                chart.render();
            });
        }
        function TimerClock(seconds, pie, status) {
            $step = 1;
            $loops = Math.round(100 / $step);
            $increment = 360 / $loops;
            $half = Math.round($loops / 2);
            $barColor = '#727272';
            $backColor = '#b2b2b2';
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
            if (status == 2) {
                $barColor = '#162fa2';
                $backColor = '#3354f1';
            }
            if (2 < status && status < 7) {
                $barColor = '#1f9402';
                $backColor = '#afff98';
            }
            // if (seconds < 10) {
            //     $barColor = '#c20000';
            //     $backColor = '#ff9595';
            // }
            // if (seconds > 1800) {
            //     $barColor = '#727272';
            //     $backColor = '#d7d6d6';
            // }
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
    @if($market!=null)
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
                    console.log(market_page_id, market_id);
                    let remain = difference % 60;
                    pie = ((100 * remain) / 60);
                    TimerClock(difference, pie, status);
                }




                if (status == 1) {
                    waiting_to_open(status, market_id, difference);
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


        function waiting_to_open(status, id, difference) {
            hide_result(id);
            // deactive_bid(id)
            // let color = '#162fa2';
            let color = '#727272';
            if (difference > 1800) {
                color = '#727272';
            }
            let statusText = '<span>Waiting To Open</span>';

            change_market_status(status, color, statusText, id)
        }

        function ready_to_open(status, id) {
            close_bid_deposit(id);
            hide_result(id);
            // deactive_bid(id);
            let statusText = '<span>Ready to open</span>';
            let color = '#162fa2';
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
            // remove_function();
            close_bid_deposit(id);
            active_bid(id);
            let color = '#1f9402';
            let statusText = '<span>Quotation 1/2</span>';
            change_market_status(status, color, statusText, id)
        }

        function Quotation_2_2(status, id) {
            hide_result(id);
            // remove_function();
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
            // remove_function();
            Competition_Bid_buttons(id);
            let color = '#1f9402';
            let statusText = '<span>Competition</span>';
            change_market_status(status, color, statusText, id)
        }

        function Stop(status, id) {
            close_bid_deposit(id);
            // remove_function();
            // deactive_bid(id);
            let color = '#c20000';
            let statusText = '<span>Close</span>';
            change_market_status(status, color, statusText, id);
        }

        function Close_and_show_result(status, id) {
            close_bid_deposit(id);
            // remove_function();
            // deactive_bid(id);
            let color = '#c20000';
            let statusText = '<span>Close</span>';
            $('#market-difference1-' + id).css({color: color})
            show_market_result(id);
            change_market_status(status, color, statusText, id);
        }

        function close_bid_deposit(id) {
            $('.bid_deposit_section-' + id).addClass('d-none');
            $('.bid_deposit_section-' + id).addClass('bg-inactive');
            $('.bid_deposit_section-' + id).find('input').prop('disabled', true);
        }

        function change_market_status(status, color, statusText, id) {
            let animation_main_div = $('#market-time-parent-' + id).find('.animation_main_div');
            animation_main_div.removeClass('d-none');
            animation_main_div.addClass('d-none');
            $('#previous_status-' + id).val(status);
            $('#market-' + id).css('color', color);
            $('#status-box-' + id).css('color', color);
            $('#market-difference1-' + id).css('color', color);
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
            seller_price.removeClass('btn-success');
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
                seller_price.addClass('btn-success');
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
                let is_delete = e.is_delete;
                refreshBidTable(market_id);
                let msg = 'New Bid Created';
                let bg = 'green';
                if (is_delete === false) {
                    ShowAlert(market_id, msg, bg);
                }

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
                        $('#final_status_section_table-' + id).show();
                        $('#final_status_section_table-' + id).removeClass('d-none');
                        $('#final_status_section-' + id).show();
                    } else {
                        console.log('error');
                    }
                }
            })
        }

        function hide_result(market_id) {
            // $('#final_status_section_table-' + market_id).hide();
            // $('#final_status_section_table-' + market_id).addClass('d-none');
            // $('#Winner_Modal').modal('hide');
        }

        function show_win_modal(id) {
            $('#Winner_Modal-' + id).modal('show');
            $('#Winner_Modal-' + id).removeAttr('id');
        }
    </script>
    @endif
@endpush
