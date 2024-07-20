{{--<h5 class="text-center text-info text-center p-3 commodity-title menu-mobile">--}}
{{--    {{ $market->SalesForm->commodity }}--}}
{{--</h5>--}}
<div id="commodity_information" style="width: 100%">
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Type/Grade</span>
        <span class="text-bold text-light-blue ">{{ $market->SalesForm->type_grade }}</span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Supplier</span>
        <span class="text-bold text-light-blue ">
                            {{ $market->SalesForm->company_type }}
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Contract Type</span>
        <span class="text-bold text-light-blue ">
                            {{ $market->SalesForm->contract_type }}
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Max Quantity</span>
        @php
        $maxQuantity=str_replace(',','',$market->SalesForm->max_quantity);
        @endphp
        <span class="text-bold text-light-blue ">{{ number_format($maxQuantity) }}</span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Min Order</span>
        @php
            $minQuantity=str_replace(',','',$market->SalesForm->min_order);
        @endphp
        <span class="text-bold text-light-blue ">{{ number_format($minQuantity) }}</span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Price Type</span>
        <span class="text-bold text-light-blue ">{{ $market->SalesForm->price_type }}</span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Offer Price</span>
        <span class="text-bold text-light-blue ">
{{--                           {{ $market->offer_price }}--}}
            @if($market->SalesForm->price_type=='Fix')
                <td class="text-center">{{ number_format($market->SalesForm->price) }}</td>
            @else
                <td class="text-center">{{ number_format($market->SalesForm->alpha)  }}</td>
            @endif
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Payment</span>
        <span class="text-bold text-light-blue ">
                            {{ $market->SalesForm->payment_term }}
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">packaging</span>
        <span class="text-bold text-light-blue ">
                            {{ $market->SalesForm->packing }}
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Term</span>
        <span class="text-bold text-light-blue ">
            {{ $market->SalesForm->incoterms }}
        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Delivery period</span>
        <span class="text-bold text-light-blue ">????</span>
    </div>

    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Origin</span>
        <span class="text-bold text-light-blue ">
                           {{ $market->SalesForm->country }}
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Specification</span>
        <span class="text-bold text-light-blue ">
                           <a target="_blank"
                              href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$market->SalesForm->specification_file)) }}">
                            Download
                        </a>
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Unit</span>
        <span class="text-bold text-light-blue ">
            {{ $market->SalesForm->unit }}
        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Currency</span>
        <span class="text-bold text-light-blue ">
            {{ $market->SalesForm->currency }}
        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">GTC</span>
        <span class="text-bold text-light-blue ">
            @if($gtc_use=='Link')
                <a target="_blank"
                   href="{{ $gtc_Link }}">
                            Download
                        </a>
            @else
                <a target="_blank"
                   href="{{ imageExist(env('UPLOAD_SETTING'),$gtc_file) }}">
                            Download
                        </a>
            @endif

                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Bid Instruction</span>
        <span class="text-bold text-light-blue ">
                           @if($bid_use=='Link')
                <a target="_blank"
                   href="{{ $Bid_Instructions_link }}">
                            Download
                        </a>
            @else
                <a target="_blank"
                   href="{{ imageExist(env('UPLOAD_SETTING'),$Bid_Instructions_file) }}">
                            Download
                        </a>
            @endif
                        </span>
    </div>
</div>

