<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from crypo.netlify.app/signin-dark by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Oct 2023 07:28:30 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
@include('home.partials.head')

<body>
@include('home.partials.header')
@yield('content')
@include('home.partials.footer')


@include('home.index.login_modal')
@include('home.index.register_modal')
@include('home.index.term_condition_modal')
@include('home.index.reset_password_modal')
{{--<script src="{{ asset('home/js/jquery-3.4.1.min.js') }}"></script>--}}
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
        crossorigin="anonymous"></script>
<script src="{{ asset('home/js/popper.min.js') }}"></script>
<script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('home/js/amcharts-core.min.js') }}"></script>
<script src="{{ asset('home/js/amcharts.min.js') }}"></script>
<script src="{{ asset('home/js/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('home/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('home/js/moment-timezone.js') }}"></script>
<script src="{{ asset('home/js/timer.js') }}"></script>
<script src="{{ asset('home/js/yscountdown.min.js') }}"></script>
<script src="{{ asset('home/js/font-awsome.js') }}"></script>
<script src="{{ asset('home/js/waypoints.js') }}"></script>
<script src="{{ asset('home/js/jquery.counterup.min.js') }}"></script>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
<script>
    $(document).ready(function() {

        $('input[name="search"]').focus(function() {

            $(this).attr('placeholder', ''); // حذف placeholder در زمان فوکوس

        });


        $('input[name="search"]').blur(function() {

            $(this).attr('placeholder', 'search...'); // بازگشت placeholder در زمان از دست دادن فوکوس

        });

    });
    window.addEventListener('beforeunload', function (event) {
        // Call logout route
        fetch('/logout', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        // // پیام تایید خروج در بعضی مرورگرها
        event.preventDefault();
        event.returnValue = ''; // برای نشان دادن پیغام کارتیک
    });

    function ShowBidPage(market_id) {
        $.ajax({
            url: "{{ route('home.ShowBidPage') }}",
            dataType: 'json',
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                market_id: market_id,
            },
            success: function (data) {
                if (data[0] == 'auth') {
                    ShowLoginModal(market_id);
                }
                if (data[0] == 'ok') {
                    let route = data[1];
                    window.location.href = route;
                }
            }

        })
    }

    function OpenModalRegister() {
        $('#login_modal').modal('hide');
        setTimeout(function () {
            ShowRegisterModal();
        }, 500);
    }

    function ShowLoginModal(market_id = null) {
        // $('.error-message').addClass('d-none');
        $('#login_modal').modal('show');
        $('#login_modal_market_id').val(market_id);
    }

    function LoginFormSubmit(tag) {
        $(tag).prop('disabled', true);
        // $('.error-message').addClass('d-none');
        let email = $('#email').val();
        let password = $('#password').val();
        let market_id = $('#login_modal_market_id').val();
        $.ajax({
            url: "{{ route('login') }}",
            data: {
                email: email,
                password: password,
                market_id: market_id,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'JSON',
            method: 'post',
            success: function (msg) {
                $(tag).prop('disabled', false);
                if (msg[0] == 3) {
                    $('#login_modal').modal('hide');
                    $('#BlockUser').modal('show');
                }
                if (msg[0] === 1) {
                    window.location.href = msg[1];
                }
                if (msg[0] === 0) {
                    $('#login_modal').modal('hide');
                    $('#anotheruserloggedin').modal('show');
                }
            },
            error: function (error) {
                $(tag).prop('disabled', false);
                let errors = error.responseJSON.errors;
                $.each(errors, function (i, val) {
                    $('#' + i + '_error').removeClass('d-none');
                    $('#' + i + '_error').text(val);
                })
            }
        });
    }

    function ShowRegisterModal() {
        // $('.error-message').add('d-none');
        $('#register_modal').modal('show');
    }

    function SubmitRegisterModal(tag) {
        $(tag).prop('disabled', true);
        // $('.error-message').addClass('d-none');
        let company_name = $('#company_name').val();
        //user type or company type
        let user_type = $('#user_type').val();
        let company_country = $('#company_country').val();
        let company_address = $('#company_address').val();
        let company_phone = $('#company_phone').val();
        let company_website = $('#company_website').val();
        let company_email = $('#company_email').val();
        let commodity = $('#commodity').val();
        let full_name = $('#full_name').val();
        let salutation = $('#salutation').val();
        let function_in_company = $('#function_in_company').val();
        let email = $('#email_register').val();
        let platform = $('#platform').val();
        let mobile_no = $('#mobile_no').val();
        let accept_term = $('input[name="accept_term"]:checked').val();
        $.ajax({
            url: "{{ route('register') }}",
            data: {
                company_name: company_name,
                user_type: user_type,
                company_country: company_country,
                company_address: company_address,
                company_phone: company_phone,
                company_website: company_website,
                company_email: company_email,
                commodity: commodity,
                full_name: full_name,
                salutation: salutation,
                function_in_company: function_in_company,
                email: email,
                platform: platform,
                mobile_no: mobile_no,
                accept_term: accept_term,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            method: 'POST',
            success: function (msg) {
                if (msg[0] === 1) {

                    $('#register_modal').modal('hide');
                    setTimeout(function () {
                        $('#AlertModal').modal('show');
                    }, 1000)
                }
            },
            error: function (error) {
                $(tag).prop('disabled', false);
                let errors = error.responseJSON.errors;
                $.each(errors, function (i, val) {
                    $('#' + i + '_error').removeClass('d-none');
                    $('#' + i + '_error').text(val);
                    if (i == 'email') {
                        $('#email_register_error').removeClass('d-none');
                        $('#email_register_error').text(val);
                    }

                })
            }
        })
    }

    function ResetPassword() {
        $('.alert_reset_password').addClass('d-none');
        $('.alert_reset_password2').addClass('d-none');
        // $('.error-message').addClass('d-none');
        console.log('reset password');
        $('#reset_password_modal').modal('show');
        $('#login_modal').modal('hide');
    }

    function SubmitResetPasswordModal() {
        $('#SubmitResetPasswordModalBtn').prop('disabled', true);
        $('.alert_reset_password').addClass('d-none');
        $('.alert_reset_password2').addClass('d-none');
        // $('.error-message').addClass('d-none');
        let email_reset_password = $('#email_reset_password').val();
        $.ajax({
            url: "{{ route('password.email') }}",
            dataType: 'json',
            method: "POST",
            data: {
                email: email_reset_password,
                _token: "{{ csrf_token() }}"
            },
            success: function (data) {
                if (data[0] == 1) {
                    $('.alert_reset_password').removeClass('d-none');
                }
                if (data[0] == 0) {
                    $('#SubmitResetPasswordModalBtn').prop('disabled', false);
                    $('.alert_reset_password2').removeClass('d-none');
                    $('.alert_reset_password2').text('Your Account is Inactive, Please Contact Admin');
                }
                if (data[0] == 2) {
                    $('#SubmitResetPasswordModalBtn').prop('disabled', false);
                    $('.alert_reset_password2').removeClass('d-none');
                    $('.alert_reset_password2').text('User Not Found');
                }
            },
            error: function (error) {
                $('#SubmitResetPasswordModalBtn').prop('disabled', false);
                let errors = error.responseJSON.errors;
                $.each(errors, function (i, val) {
                    $('#email_reset_password_error').removeClass('d-none');
                    $('#email_reset_password_error').text(val);
                })

            }
        })
    }

    function ShowTermConditionModal() {
        $('#term_condition_modal').modal('show');
    }

    function header_search(tag, event) {
        if (event.keyCode == 13) {
            let val = $(tag).val();
            let url = "{{ route('home.search') }}"
            $.ajax({
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    value: val,
                },
                dataType: 'json',
                method: 'post',

            })
        }
    }

    function ShowMenu() {
        $('.mobile-nav').addClass('mobile-nav-open');
        $('#bg-mute').show();
    }

    function CloseMenu() {
        $('.mobile-nav').removeClass('mobile-nav-open');
        $('#bg-mute').hide();
    }

    $(document).ready(function () {
        let width = window.innerWidth;
        if (width < 992) {
            $('.menu-des').remove();
        } else {
            $('.menu-mobile').remove();
        }
    });
    var timerCountdown = 0;

    function makeTimer(endTime, market_is_open, now) {
        // به‌روزرسانی زمان endTime با زمان فعلی
        endTime = moment(endTime).tz('Europe/London').format("MMMM Do YYYY h:mm:ss A");
        // محاسبه زمان فعلی
        let time_now = moment(now).tz('Europe/London').format("MMMM Do YYYY h:mm:ss A");
        // محاسبه اختلاف زمانی بین endTime و time_now بر حسب میلی‌ثانیه
        console.log(market_is_open);
        var diffMilliseconds = moment(endTime, "MMMM Do YYYY h:mm:ss A").diff(moment(time_now, "MMMM Do YYYY h:mm:ss A"));
        // تبدیل اختلاف زمانی به ثانیه
        var diffSeconds = Math.abs(diffMilliseconds) / 1000;

        if (market_is_open == 0) {
            clearInterval(timerCountdown);
            timerClose();
        } else {
            if (!timerCountdown == 0) {
                clearInterval(timerCountdown);
            }
            timerCountdown = setInterval(function () {
                Timer(diffSeconds);
                diffSeconds = diffSeconds - 1;
            }, 1000);
        }
    }

    function timerClose() {
        var Hours = $('#Hours');
        var Minutes = $('#Minutes');
        var Seconds = $('#Seconds');
        Hours.text('00');
        Minutes.text('00');
        Seconds.text('00');
    }

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

    jQuery(document).ready(function ($) {
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });

    });

    $('.open_page_description').click(function () {
        let is_open = $(this).attr('data-open');
        let button_html = '';
        if (is_open === 'no') {
            button_html = `نمایش کمتر
                    <i class="fa fa-angle-up ml-3"></i>`;
            $(this).parent().removeClass('page_description');
            $(this).parent().addClass('page_description2');
            $(this).attr('data-open', 'yes');
        } else {
            button_html = `نمایش بیشتر
                    <i class="fa fa-angle-down ml-3"></i>`;
            $(this).parent().removeClass('page_description2');
            $(this).parent().addClass('page_description');
            $(this).attr('data-open', 'no');
        }
        $(this).html(button_html);
    })
    let header1Width = $('#scroll-container').find('div')[0].clientWidth;
    let width = screen.width;
    if (header1Width > width) {
        $('#scroll-container').addClass('scroll-container');
    }
    let header1Width2 = $('#scroll-container2').find('div')[0].clientWidth;
    let width2 = screen.width;
    if (header1Width2 > width2) {
        $('#scroll-container2').addClass('scroll-container');
    }


    function active_bid(id) {
        $('#bid_quantity-' + id).prop('disabled', false);
        $('#bid_quantity-' + id).addClass('btn-success');

        $('#bid_price-' + id).prop('disabled', false);
        $('#bid_price-' + id).addClass('btn-success');

        $('#bid_button-' + id).prop('disabled', false);
        $('#bid_button-' + id).addClass('btn-success');
    }

    function Competition_Bid_buttons(id) {
        $('#bid_quantity-' + id).prop('disabled', true);
        $('#bid_quantity-' + id).addClass('d-none');

        $('#bid_price-' + id).prop('disabled', false);
        $('#bid_price-' + id).addClass('btn-success');

        $('#bid_button-' + id).prop('disabled', false);
        $('#bid_button-' + id).addClass('btn-success');
    }

    function deactive_bid(id) {
        $('#bid_quantity-' + id).val(' ');
        $('#bid_price-' + id).val(' ');

        $('#bid_quantity-' + id).prop('disabled', true);
        $('#bid_quantity-' + id).removeClass('btn-success');

        $('#bid_price-' + id).prop('disabled', true);
        $('#bid_price-' + id).removeClass('btn-success');

        $('#bid_button-' + id).prop('disabled', true);
        $('#bid_button-' + id).removeClass('btn-success');

        $('#PayBidDepositBTN-' + id).prop('disabled', true);
    }


    function competition_bid_buttons(id) {
        $('#bid_quantity-' + id).prop('disabled', true);
    }

    function removeBid(market_id, bid_id) {
        $('#remove_bid_modal_' + market_id).modal('show');
        $('#delete_bid_button_' + market_id).removeAttr('onclick');
        $('#delete_bid_button_' + market_id).attr('onclick', 'ForceRemoveBid(' + market_id + ',' + bid_id + ')');
    }

    function ForceRemoveBid(market_id, bid_id) {
        $.ajax({
            url: "{{  route('home.remove_bid') }}",
            data: {
                bid_id: bid_id,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            method: "post",
            success: function () {
                console.error('ppppppppppppppppppp');
                $('#remove_bid_modal_' + market_id).modal('hide');
            }
        })
    }

    function remove_function() {
        $('.remove_function').remove();
    }

    function Bid(market_id) {
        $('#accept_term_alert').hide();
        $('#bid_validate_error').hide();
        let is_checked = $('#CheckTermCondition_' + market_id).is(':checked');
        if (!is_checked) {
            window.location.href = "#CheckTermCondition_" + market_id;
            $('#accept_term_alert').show();
            ValidateError(market_id, 'Accept term condition');
            return;
        }
        $('.error_text').hide();
        let price = $('#bid_price-' + market_id).val();
        let quantity = $('#bid_quantity-' + market_id).val();

        price = price.replaceAll(',', '');
        quantity = quantity.replaceAll(',', '');
        $.ajax({
            url: "{{  route('home.bid_market') }}",
            data: {
                price: price,
                quantity: quantity,
                market: market_id,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            method: "post",

            beforeSend: function () {
                $('#bid_button-' + market_id).prop('disabled', true);
            },

            success: function (msg) {
                if (msg[0] === 'error') {
                    // alert(msg[1]);
                    ValidateError(market_id, msg[1]);
                }
                if (msg[0] === 'price_quantity') {
                    $('#bid_validate_error').text(msg[2]);
                    $('#bid_validate_error').show();
                    // $('#bid_' + msg[1] + '_error').text(msg[2]);
                    // $('#bid_' + msg[1] + '_error').show();
                }
                if (msg[0] === 'alert') {
                    // alert(msg[2]);
                    ValidateError(market_id, msg[2]);
                }

                if (msg[0] == 1) {
                    $('#bid_price-' + market_id).val(' ');
                    $('#bid_quantity-' + market_id).val(' ');
                    refreshBidTable(market_id);
                }

                $('#bid_button').prop('disabled', false);
                $('#bid_button').prop('disabled', false);
            },
            error: function (msg) {
                if (msg.responseJSON.errors) {
                    let errors = msg.responseJSON.errors;
                    let error_text = '';
                    let j = 0;
                    $.each(errors, function (i, val) {
                        if (j == 0) {
                            error_text = '<i class="fa-solid fa-triangle-exclamation mr-2"></i>' + val;
                        } else {
                            error_text = error_text + '<br>' + '<i class="fa-solid fa-triangle-exclamation mr-2"></i>' + val;
                        }
                        j++;
                        $('#bid_validate_error').html(error_text);
                        $('#bid_validate_error').show();
                    })
                }
                active_bid(market_id);
            }
        })

    }

    function Offer(market_id) {
        $('.error_text').hide();
        let status = $('#previous_status-' + market_id).val();
        let price_is_disable = $('#seller_price-' + market_id).attr('disabled');
        let price = $('#seller_price-' + market_id).val();
        if (price_is_disable) {
            price = 'disabled';
        }
        price = price.replaceAll(',', '');
        $.ajax({
            url: "{{  route('home.seller_change_offer') }}",
            data: {
                price: price,
                // quantity: quantity,
                market_id: market_id,
                status: status,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            method: "post",
            success: function (msg) {
                if (msg) {
                    if (msg[1] == 'error') {
                        ValidateError(market_id, msg[2]);
                        // alert(msg[2]);
                    } else {
                        $('#seller_price-' + market_id).val('');
                    }
                }
            },
        })
    }

    function ValidateError(market_id, message) {
        let validate_modal = $('#validate_modal_' + market_id);
        let validate_modal_body = $('#validate_modal_body_' + market_id);
        validate_modal_body.text(message);
        validate_modal.modal('show');
    }


    function countdownTimmer(timer2, color) {
        var interval = setInterval(function () {
            var timer = timer2.split(':');
            //by parsing integer, I avoid all extra string processing
            var minutes = parseInt(timer[0], 10);
            var seconds = parseInt(timer[1], 10);
            --seconds;
            minutes = (seconds < 0) ? --minutes : minutes;
            if (minutes < 0) clearInterval(interval);
            seconds = (seconds < 0) ? 59 : seconds;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            //minutes = (minutes < 10) ?  minutes : minutes;
            if (minutes < 0) {
                $('.countdown').html('0:00');
            } else {
                $('.countdown').html(minutes + ':' + seconds);
            }

            $('.countdown').css('background', color)
            timer2 = minutes + ':' + seconds;
        }, 1000);
    }


    function secondsToHms(d) {
        d = Number(d);
        var h = Math.floor(d / 3600);
        var m = Math.floor(d % 3600 / 60);
        var s = Math.floor(d % 3600 % 60);
        var hDisplay = h;
        if (h < 10) {
            hDisplay = '0' + h;
        }
        var mDisplay = m;
        if (m < 10) {
            mDisplay = '0' + m;
        }
        var sDisplay = s;
        if (s < 10) {
            sDisplay = '0' + s;
        }


        return hDisplay + ':' + mDisplay + ':' + sDisplay;
    }


    function refreshBidTable(market) {
        $.ajax({
            url: "{{ route('home.refreshBidTable') }}",
            data: {
                _token: "{{ csrf_token() }}",
                market: market
            },
            dataType: "json",
            method: 'post',
            success: function (msg) {
                if (msg) {
                    $('#bidder_offer_' + market).html(msg[1]);
                }
            }
        })
    }

    function refreshSellerTable(market) {
        $.ajax({
            url: "{{ route('home.refreshSellerTable') }}",
            data: {
                _token: "{{ csrf_token() }}",
                market: market
            },
            dataType: "json",
            method: 'post',
            success: function (msg) {
                if (msg) {
                    $('#seller_offer_table').html(msg[1]);
                }
            }
        })
    }

    var screen_width = window.matchMedia("(max-width: 596px)").matches;

    if (screen_width) {
        $('#scroll-container').on('touchstart', function () {
            $('#scroll-container-first-div').addClass('animate_paused');
        })
        $('#scroll-container').on('touchend', function () {
            $('#scroll-container-first-div').removeClass('animate_paused');
        })
        $('#scroll-container2').on('touchstart', function () {
            $('#scroll-container-first-div2').addClass('animate_paused');
        })
        $('#scroll-container2').on('touchend', function () {
            $('#scroll-container-first-div2').removeClass('animate_paused');
        })
    } else {
        $('#scroll-container').hover(function () {
            $('#scroll-container-first-div').addClass('animate_paused');
        }, function () {
            $('#scroll-container-first-div').removeClass('animate_paused');
        });
        $('#scroll-container2').hover(function () {
            $('#scroll-container-first-div2').addClass('animate_paused');
        }, function () {
            $('#scroll-container-first-div2').removeClass('animate_paused');
        });
    }


    function step_price_competition(tag, event) {

    }

    function ShowPass(tag) {
        $(tag).addClass('d-none');
        $('#fa-eye-slash').removeClass('d-none');
        $('#password').attr('type', 'text');
    }

    function HidePass(tag) {
        $(tag).addClass('d-none');
        $('#fa-eye').removeClass('d-none');
        $('#password').attr('type', 'password');
    }


</script>
<script src="{{ asset('admin/js/bootstrap-select.min.js') }}"></script>
<script>
    $('select').selectpicker({
        'title': 'Select'
    });
</script>
@yield('script')
</body>


<!-- Mirrored from crypo.netlify.app/signin-dark by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Oct 2023 07:28:30 GMT -->
</html>
