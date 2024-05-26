@extends('home.homelayout.app')

@section('script')
    <script type="module">
        $(document).ready(function () {
            {{--GetMarket({{ $market->id }});--}}
            {{--let now = '{{ $now }}';--}}
            {{--now = new Date(now).getTime();--}}
            {{--MarketOnline({{ $market->id }}, now);--}}
        });
        window.Echo.channel('market-status-updated')
            .listen('MarketStatusUpdated', function (e) {
                let market_id = e.market_id;
                let difference = e.difference;
                let timer = e.timer;
                let status = e.status;
                let price_step = e.step;
                $('#market-difference-' + market_id).html(timer);
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
                    Competition(status, market_id, price_step);
                }
                if (status == 7) {
                    Stop(status, market_id);
                }
                if (status == 8) {
                    Finished(status, market_id);
                }
                if (status == 9) {
                    No_Winner(status, market_id);
                }


            });

        function waiting_to_open(status, id) {
            hide_result(id);
            deactive_bid(id);
            let statusText = '<span>Waiting To Open</span>';
            let color = '#3b3b00';
            change_market_status(status, color, statusText, id)
        }

        function ready_to_open(status, id) {
            close_bid_deposit(id);
            hide_result(id);
            deactive_bid(id);
            let statusText = '<span>Ready to open</span>';
            let color = '#8a8a00';
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
            let color = '#135e00';
            let statusText = '<span>Quotation 1/2</span>';
            change_market_status(status, color, statusText, id)
        }

        function Quotation_2_2(status, id) {
            hide_result(id);
            remove_function();
            close_bid_deposit(id);
            active_bid(id);
            let color = '#104800';
            let statusText = '<span>Quotation 2/2</span>';
            change_market_status(status, color, statusText, id)
        }

        function Competition(status, id, step) {
            close_bid_deposit(id);
            $('#bid_price').attr('onkeyup', 'step_price_competition(this,event)');
            $('#bid_price').attr('step', step);
            remove_function();
            Competition_Bid_buttons(id);
            let color = '#0a2a00';
            let statusText = '<span>Competition</span>';
            change_market_status(status, color, statusText, id)
        }

        function Stop(status, id) {
            close_bid_deposit(id);
            remove_function();
            deactive_bid(id);
            let color = '#ff0707';
            let statusText = '<span>Close</span>';
            change_market_status(status, color, statusText, id);
        }

        function Finished(status, id) {
            close_bid_deposit(id);
            remove_function();
            deactive_bid(id);
            let color = '#0a0a0a';
            let statusText = '<span>Complete</span>';
            show_market_result(id,0);
            change_market_status(status, color, statusText, id);
        }
        function No_Winner(status, id) {
            close_bid_deposit(id);
            remove_function();
            deactive_bid(id);
            let color = '#c7aa14';
            let statusText = '<span>FAILED</span>';
            show_market_result(id,1);
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
            $('#market-difference-'+id).css('background', color);
            $('#market-status-' + id).html(statusText);
            if (status == 2 || status == 3 || status == 4 || status == 5) {
                animation_main_div.removeClass('d-none');
            }
            sales_offer_buttons(status,id);
        }

        function sales_offer_buttons(status,id) {
            // let seller_quantity = $('#seller_quantity-'+id);
            let seller_price = $('#seller_price-'+id);
            let seller_button = $('#seller_button-'+id);
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
            if (status == 7) {
                // seller_quantity.prop('disabled', true);
                seller_price.prop('disabled', true);
                seller_button.prop('disabled', true);
            }
        }

        window.Echo.channel('change-sales-offer')
            .listen('ChangeSaleOffer', function (e) {
                let market_id = e.market_id;
                refreshSellerTable(market_id);
            });
        window.Echo.channel('market-setting-updated-channel')
            .listen('MarketTimeUpdated', function (e) {
                {{--GetMarket({{ $market->id }}, e.now);--}}
            });
        window.Echo.channel('new_bid_created')
            .listen('NewBidCreated', function (e) {
                let market_id = e.market_id;
                refreshBidTable(market_id);
            });

        function show_market_result(id,failed) {
            $.ajax({
                url: "{{ route('home.get_market_bit_result') }}",
                data: {
                    id: id,
                    failed:failed,
                },
                dataType: "json",
                method: "POST",
                success: function (msg) {
                    if (msg[0] == 1) {
                        let is_winner = msg[2];
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

        function show_win_modal() {
            $('#Winner_Modal').modal('show');
            $('#Winner_Modal').removeAttr('id');
        }




    </script>
@endsection

@section('style')
    <style>

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
            width: 140px;
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
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-12 col-md-12 col-xl-4 mb-1 d-flex justify-content-center align-center">
                <h5 class="text-center text-info text-center p-3" style="margin-bottom: 0 !important;">
                    {{ $market->SalesForm->commodity }}
                </h5>
            </div>
            <div class="col-12 col-md-12 col-xl-8 mb-1">
                <h5 id="status-box-{{ $market->id }}" class="text-center">
                    Step : <span id="market-status-{{ $market->id }}"></span>
                </h5>
                <span id="market-difference-{{ $market->id }}" class="circle_timer">

                        </span>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-12 col-md-12 col-xl-3 mb-5">
                @include('home.market.market_info')
            </div>
            <div class="col-12 col-md-12 col-xl-8 mb-5">
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
                                    <th class="text-center text-white">Quantity( {{ $market->SalesForm->unit }})
                                    </th>
                                    <th class="text-center text-white">Price ( {{ $market->SalesForm->currency }}
                                        )
                                    </th>
                                    <th class="text-center text-white">
                                        Bidder
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
                                            <label for="seller_price-{{ $market->id }}">Price( {{ $market->SalesForm->currency }}
                                                )</label>
                                            <input disabled id="seller_price-{{ $market->id }}" type="text" class="form-control"
                                                   name="seller_quantity-{{ $market->id }}">
                                            <p id="seller_price_error" class="error_text">please enter price</p>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <button disabled id="seller_button-{{ $market->id }}" onclick="Offer({{ $market->id }})"
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
                                    <div id="bid_validate_error" class="alert alert-danger text-left p-2">

                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mt-3 text-center">
                                        <label for="bid_quantity-{{ $market->id }}">Quantity( {{ $market->SalesForm->unit }} )</label>
                                        <input disabled id="bid_quantity-{{ $market->id }}" type="text" class="form-control">
                                        <p id="bid_quantity_error" class="error_text">please enter quantity</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mt-3 text-center">
                                        <label for="bid_price-{{ $market->id }}">Price( {{ $market->SalesForm->currency }} )</label>
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
                                    <th class="text-center text-white w-50">Quantity( {{ $market->SalesForm->unit }})
                                    </th>
                                    <th class="text-center text-white w-50">Price ( {{ $market->SalesForm->currency }}
                                        )
                                    </th>

                                    <th class="text-center text-white w-50">
                                        user id
                                    </th>

                                    <th class="text-center text-white w-50">
                                        Quantity_win
                                    </th>
                                    <th class="text-center text-white w-50">
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

@endsection
