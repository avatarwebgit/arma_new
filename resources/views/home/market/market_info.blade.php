

<div id="commodity_information" style="width: 100%">
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">commodity</span>
        <span class="text-bold text-light-blue ">{{ $market->SalesForm->commodity }}</span>
    </div>
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
        <span class="text-bold text-gray-100">Max Quantity</span>
        <span class="text-bold text-light-blue ">{{ $market->SalesForm->max_quantity }}</span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Min Order</span>
        <span class="text-bold text-light-blue ">{{ $market->SalesForm->min_order }}</span>
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
        <span class="text-bold text-gray-100">packaging</span>
        <span class="text-bold text-light-blue ">
                            {{ $market->SalesForm->packing }}
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Contract Type</span>
        <span class="text-bold text-light-blue ">
                            {{ $market->SalesForm->contract_type }}
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Offer Price</span>
        <span class="text-bold text-light-blue ">
{{--                           {{ $market->offer_price }}--}}
            {{ $market->SalesForm->price }}
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Payment</span>
        <span class="text-bold text-light-blue ">
                            {{ $market->SalesForm->payment_term }}
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Origin</span>
        <span class="text-bold text-light-blue ">
                           {{ $market->SalesForm->country }}
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Destination</span>
        <span class="text-bold text-light-blue ">
            {{ $market->SalesForm->destination }}
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
        <span class="text-bold text-gray-100">Bid increment</span>
        <span class="text-bold text-light-blue ">????</span>
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
        <span class="text-bold text-gray-100">Analysis</span>
        <span class="text-bold text-light-blue ">
                        <a target="_blank"
                           href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$market->SalesForm->msds)) }}">
                           ????
                        </a>
                        </span>
    </div>

    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">GTC</span>
        <span class="text-bold text-light-blue ">
                        <a target="_blank"
                           href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$market->SalesForm->msds)) }}">
                           ????
                        </a>
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Bid Instruction</span>
        <span class="text-bold text-light-blue ">
                        <a target="_blank"
                           href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$market->SalesForm->msds)) }}">
                           ????
                        </a>
                        </span>
    </div>
    <div class="d-flex justify-content-between">
        <span class="text-bold text-gray-100">Bid Deposit Instruction</span>
        <span class="text-bold text-light-blue ">
                        <a target="_blank"
                           href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$market->SalesForm->msds)) }}">
                           ????
                        </a>
                        </span>
    </div>
</div>
