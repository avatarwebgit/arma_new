
<div class="col-12 col-md-12 col-xl-8 mb-5 menu-mobile">
    <div class="row mb-4">
        <div class="col-12 col-md-6 mb-3">
            <div class="row">
                <div class="col-12">
                    <h5 id="status-box-{{ $market->id }}" class="text-center">
                        Step : <span id="market-status-{{ $market->id }}"></span>
                    </h5>

                    <div class="clockk-wrap">
                        <div class="clockk pro-0">
                        <span id="market-difference1-{{ $market->id }}" class="d-flex timer-clock">

                        </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12">
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
                <div class="col-12 col-md-12">
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
            </div>

        </div>
        <div class="col-12 col-md-6 mb-3">
            <div class="row">
                <div class="col-12 col-md-12">
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
                <div class="col-12  col-md-12">
                    @if(auth()->user()->hasRole('buyer') or auth()->user()->hasRole('admin'))
                        <div class="row">
                            <div class="col-12">
                                <div id="bid_validate_error" class="alert alert-danger text-left p-2">

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
            </div>
        </div>
    </div>
    <div class="row">

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
{{--            @include('home.market.bid_deposit')--}}
        </div>
    </div>
</div>


{{--git --}}
