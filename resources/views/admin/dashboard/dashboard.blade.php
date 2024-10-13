@extends('admin.layouts.main')
@section('title', __('Dashboard'))
@section('content')
    <div class="row g-5 g-xl-8">
        @include('admin.dashboard.profile')
        @include('admin.dashboard.markets')
        @include('admin.dashboard.settings')
        @include('admin.dashboard.market_chart')
{{--        @include('admin.dashboard.users')--}}
{{--        @include('admin.dashboard.inquiries')--}}
{{--        @include('admin.dashboard.sales_order')--}}

    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/cssfamily=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('metronik/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronik/assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('metronik/assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('metronik/assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .dash-content {
            background-color: white;
        }
        .text-white{
            color: white !important;
        }
        .item-dashboard{
            text-align: center;
            font-size: 18px;
            border-radius: 5px;
            background: #fff;
            height: 80px;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }
        .bg-primary{
            background-color:red !important;
        }
    </style>
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
        var initMixedWidget10 = function() {
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

            [].slice.call(charts).map(function(element) {
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
    </script>
@endpush
