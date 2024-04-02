@extends('home.homelayout.app')

@section('script')
    <script type="module">
        $(document).ready(function () {
            MarketOnline({{ $market->id }});
        });
        window.Echo.channel('change-sales-offer')
            .listen('ChangeSaleOffer', function (e) {
                let market_id = e.market_id;
                refreshSellerTable(market_id);
            });
        window.Echo.channel('market-setting-updated-channel')
            .listen('MarketTimeUpdated', function (e) {
                GetMarket({{ $market->id }});
            });
        window.Echo.channel('new_bid_created')
            .listen('NewBidCreated', function (e) {
                let market_id = e.market_id;
                refreshBidTable(market_id);
            });

        function GetMarket(market_id) {
            $.ajax({
                url: "{{ route('home.GetMarket') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    market_id: market_id,
                },
                method: 'post',
                dataType: 'json',

                success: function (msg) {
                    let table_view = msg[1];
                    $('#benchmark_info').html(table_view);
                    MarketOnline(market_id);
                }
            })
        }

        function step_price_competition(tag, event) {
            event.preventDefault();
            alert('Use Arrow Buttons to Increase or Decrease');
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
                <h5 class="text-center status-box">
                    Step : <span id="market-status-{{ $market->id }}"></span>
                </h5>
                <span id="market-difference-{{ $market->id }}" class="circle_timer">

                        </span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12 col-xl-4 mb-5">
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
                                    <th class="text-center text-white">

                                    </th>
                                    <th style="font-size: 12pt" class="text-center text-white">Quantity( {{ $market->SalesForm->unit }})
                                    </th>
                                    <th style="font-size: 12pt" class="text-center text-white">Price ( {{ $market->SalesForm->currency }}
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
                                    <div class="col-12 col-md-6">
                                        <div class="mt-3">
                                            <label for="seller_quantity">Quantity( {{ $market->SalesForm->unit }}
                                                )</label>
                                            <input disabled id="seller_quantity" type="text" class="form-control"
                                                   name="seller_quantity">
                                            <p id="seller_quantity_error" class="error_text">please enter quantity</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mt-3">
                                            <label for="seller_price">Price( {{ $market->SalesForm->currency }}
                                                )</label>
                                            <input disabled id="seller_price" type="text" class="form-control"
                                                   name="seller_quantity">
                                            <p id="seller_price_error" class="error_text">please enter price</p>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <button disabled id="seller_button" onclick="Offer({{ $market->id }})"
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
                                    <div class="mt-3">
                                        <label for="bid_quantity">Quantity( {{ $market->SalesForm->unit }} )</label>
                                        <input disabled id="bid_quantity" type="text" class="form-control">
{{--                                        <p id="bid_quantity_error" class="error_text">please enter quantity</p>--}}
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mt-3">
                                        <label for="bid_price">Price( {{ $market->SalesForm->currency }} )</label>
                                        <input disabled id="bid_price" type="number" class="form-control">
{{--                                        <p id="bid_price_error" class="error_text">please enter price</p>--}}
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-3">
                                    <button id="bid_button" disabled onclick="Bid({{ $market->id }})"
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
                                    @if(auth()->user()->hasRole('admin'))
                                        <th class="text-center text-white w-50">
                                            user
                                        </th>
                                    @endif
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
@endsection
