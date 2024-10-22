<!DOCTYPE html>
<html lang="en"
      dir="ltr">
<head>
    <title>{{  $title }} | Panel</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon"
          href="{{ imageExist(env('UPLOAD_SETTING'),$fav_icon) }}"
          type="image/png">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notifier.css') }}">
    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/css/jquery-confirm.min.css') }}">
    <!-- Bootstrap datetimepicker css -->
    {{-- <link rel="stylesheet" href="{{asset('assets/css/plugins/datepicker-bs5.min.css')}}"> --}}
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('vendor/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/developer.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/bootstrap-clockpicker.min.css') }}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"
          integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <style>
        .button_create_modal {
            border: 1px solid black;
            background: white;
            color: black;
            width: 100px;
            padding: 3px 10px;
            text-align: center;
            margin: 5px 10px;
        }
        .dash-container{
            top: 0 !important;
        }
        .dash-container .dash-content{
            padding-top: 0 !important;
        }
    </style>
    @vite(['resources/sass/app.scss','resources/js/app.js'])
    @stack('style')
</head>

<body class="theme-4">
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>


</div>
<!-- [ Pre-loader ] End -->
<!-- [ Mobile header ] start -->
<div class="dash-mob-header dash-header" style="background-color: #006">
    <div class="pcm-logo">

    </div>
    <div class="pcm-toolbar">
        <a href="#!" class="dash-head-link" id="mobile-collapse">
            <div class="hamburger hamburger--arrowturn">
                <div class="hamburger-box">
                    <div class="hamburger-inner"></div>
                </div>
            </div>
            <!-- <i data-feather="menu"></i> -->
        </a>

    </div>
</div>


<!-- [ Mobile header ] End -->
<!-- [ navigation menu ] start -->
@include('admin.layouts.sidebar')

<!-- [ navigation menu ] end -->
<!-- [ Header ] start -->
{{--@include('admin.include.header')--}}

<!-- Modal -->
<div class="modal notification-modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                <h6 class="mt-2">
                    <i data-feather="monitor" class="me-2"></i>{{ __('Desktop settings') }}
                </h6>
                <hr/>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="pcsetting1" checked/>
                    <label class="form-check-label f-w-600 pl-1"
                           for="pcsetting1">{{ __('Allow desktop notification') }}</label>
                </div>
                <p class="text-muted ms-5">
                    {{ __('you get lettest content at a time when data will updated') }}
                </p>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="pcsetting2"/>
                    <label class="form-check-label f-w-600 pl-1" for="pcsetting2">{{ __('Store Cookie') }}</label>
                </div>
                <h6 class="mb-0 mt-5">
                    <i data-feather="save" class="me-2"></i>{{ __('Application settings') }}
                </h6>
                <hr/>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="pcsetting3"/>
                    <label class="form-check-label f-w-600 pl-1"
                           for="pcsetting3">{{ __('Backup Storage') }}</label>
                </div>
                <p class="text-muted mb-4 ms-5">
                    {{ __('Automaticaly take backup as par schedule') }}
                </p>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="pcsetting4"/>
                    <label class="form-check-label f-w-600 pl-1"
                           for="pcsetting4">{{ __('Allow guest to print file') }}</label>
                </div>
                <h6 class="mb-0 mt-5">
                    <i data-feather="cpu" class="me-2"></i>{{ __('System settings') }}
                </h6>
                <hr/>
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input" id="pcsetting5" checked/>
                    <label class="form-check-label f-w-600 pl-1"
                           for="pcsetting5">{{ __('View other user chat') }}</label>
                </div>
                <p class="text-muted ms-5">{{ __('Allow to show public user message') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger btn-sm" data-bs-dismiss="modal">
                    {{ __('Close') }}
                </button>
                <button type="button" class="btn btn-light-primary btn-sm">
                    {{ __('Save changes') }}
                </button>
            </div>
        </div>
    </div>
</div>
<!-- [ Header ] end -->
</body>

<!-- [ Main Content ] start -->
<div class="dash-container">
    <div class="dash-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    @yield('breadcrumb')
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        @yield('content')

        <!-- [ Main Content ] end -->
    </div>
</div>

<div class="modal fade" role="dialog" id="common_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="body">
                <p></p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="common_modal1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" id="common_modal2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="CreateMarketModal" tabindex="-1" role="dialog" aria-labelledby="Edit_Currency"
     aria-hidden="true">
    <div style="max-width: 768px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center position-relative">
                <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"
                   style="position: absolute;right: 10px;top: 10px"></i>
                <h3>
                    Enter Date
                </h3>
            </div>
            <div id="modal_body" class="modal-body p-5 row">
                <div id="deposit_input" class="mb-3 mt-3  row">
                    <div class="mt-3 mb-3 col-12">
                        <input class="form-control" type="date" id="Market_Date">
                    </div>
                </div>
                <input id="id_cash_pending" type="hidden">
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="button_create_modal" data-dismiss="modal" aria-label="Close" type="button">Cancel
                </button>
                <button class="button_create_modal" onclick="CreateMarketModal()" type="button">Create</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
{{--<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/dash.js') }}"></script>
<script src="{{ asset('vendor/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/js/plugins/notifier.js') }}"></script>
<script src="{{ asset('vendor/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bouncer.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-validation.js') }}"></script>
<script src="{{ asset('admin/fullCKEditor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap-clockpicker.min.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap-select.min.js') }}"></script>

@if (!empty(setting('gtag')))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('gtag') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', '{{ setting('gtag') }}');
    </script>
@endif

<script>
    $('select').selectpicker({
        'title': 'Select'
    });
    function numberFormat(tag) {
        let number = $(tag).val();
        let number_formatted = number_format_js(number);
        $(tag).val(number_formatted);
    }

    function number_format_js(number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    feather.replace();
    var pctoggle = document.querySelector("#pct-toggler");
    if (pctoggle) {
        pctoggle.addEventListener("click", function () {
            if (
                !document.querySelector(".pct-customizer").classList.contains("active")
            ) {
                document.querySelector(".pct-customizer").classList.add("active");
            } else {
                document.querySelector(".pct-customizer").classList.remove("active");
            }
        });
    }

    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }

    $('#profile-toggle').click(function () {
        $('#profile-dropdown').slideToggle();
    })
    $('.clockpicker').clockpicker();


    function createMarketModal() {
        $('#CreateMarketModal').modal('show');
    }

    function CreateMarketModal() {
        let Market_Date = $('#Market_Date').val();
        if (Market_Date.length > 0) {
            let url = "{{ route('admin.market.create',['market_data'=>':market_data']) }}";
            url = url.replace(':market_data', Market_Date);
            window.location.href = url;
        } else {
            alert('Please select Date');
        }
    }

    function ChangeLineSpeed(line, tag) {
        let value = $(tag).val();
        $.ajax({
            url: "{{ route('admin.ChangeLineSpeed') }}",
            data: {
                _token: "{{ csrf_token() }}",
                value: value,
                line: line,
            },
            dataType: 'json',
            method: 'POST',
            success: function(msg){
                console.log(msg);
            }
        });

    }
</script>
@yield('script')
@include('admin.layouts.includes.alerts')
@stack('script')
</body>
</html>
