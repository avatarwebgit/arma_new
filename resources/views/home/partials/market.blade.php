<table class="table table-responsive-sm">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Commodity</th>
        <th scope="col">Quantity</th>
        <th scope="col">Packaging</th>
        <th scope="col">Delivery Term</th>
        <th scope="col">Region</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($yesterday_markets_groups as $markets)

        @foreach($markets->sortby('time') as $key=>$market)
            <input type="hidden" id="previous_status-{{ $market->id }}" value="{{ $market->status }}">
            @php
                $row_color='black';
            @endphp
            <tr style="color: {{ $row_color }} !important;" id="market-{{ $market->id }}"
                data-status="{{ $market->status }}"
                data-difference="{{ $market->difference }}"
                data-benchmark1="{{ $market->benchmark1 }}"
                data-benchmark2="{{ $market->benchmark2 }}"
                data-benchmark3="{{ $market->benchmark3 }}"
                data-benchmark4="{{ $market->benchmark4 }}"
                data-benchmark5="{{ $market->benchmark5 }}"
                data-benchmark6="{{ $market->benchmark6 }}"
                data-today-last="{{ $market->is_today_last }}"
            >
                <td>


                    {{ $market->SalesForm->commodity }}
                </td>
                <td>
                    {{ $market->SalesForm->max_quantity.'('.$market->SalesForm->unit.')' }}
                </td>
                <td>
                    {{ $market->SalesForm->packing }}
                </td>
                <td>
                    {{ $market->SalesForm->incoterms }}
                </td>
                <td>
                    {{ $market->SalesForm->country }}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($market->date_time)->format('Y-m-d') }}
                </td>
                {{--                <td id="market-time-{{ $market->id }}">--}}
                {{--                    {{ \Carbon\Carbon::parse($market->date_time)->format('H:i') }}--}}
                {{--                </td>--}}
                <td>
                    {{ $market->status }}
                </td>
                <td id="slide_more_angle_{{ $market->id }}" onclick="slidemore({{ $market->id }})"
                    class="slide_more_angle cursor-pointer">
                    <div class="d-flex">
                        <span>more</span>
                        <i class="fa fa-angle-down"></i>
                    </div>
                </td>
                <td>
                    <a href="{{ route('home.bid',['market'=>$market->id]) }}" class="btn btn-primary bid-bottom btn-sm">
                        Bid
                    </a>
                </td>
            </tr>
            <tr id="more_table_{{ $market->id }}" style="display: none" class="slide_more_table">
                <td colspan="11">
                    <table class="table-striped table_in_table" style="width: 100%">
                        <tr>
                            <td class="text-center">
                                <span class="text-bold">Specification</span>
                                <span>Available</span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Contract Type</span>
                                <span> {{ $market->SalesForm->price_type }}</span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Offer Price</span>
                                <span>
                                    @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="text-bold">Partial Shipment</span>
                                <span>{{ $market->SalesForm->partial_shipment }}</span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Supplier</span>
                                <span>{{ $market->SalesForm->company_type }}</span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Peyment Term</span>
                                <span>
                                    @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="text-bold">Insurance</span>
                                <span>Available</span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Target Market</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->target_market }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="text-bold">Delivery Date</span>
                                <span>
                                    @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="text-bold">Min Order</span>
                                <span>
                                   {{ $market->SalesForm->min_order }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Inspection</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->quality_quantity_inspection }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Documents</span>
                                <span>
                                   @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endforeach
    @endforeach
    @foreach($markets_groups as $markets)

        @foreach($markets->sortby('time') as $key=>$market)
            @php
                if ($market->status == 1){
                    $statusText = '<span>Waiting To Open</span>';
                   $color = '#3b3b00';
                   $statusText=Carbon\Carbon::parse($market->time)->format('g:i A');
                }
                if ($market->status == 2){
                     $statusText = '<span>Ready to open</span>';
                     $color = '#8a8a00';
                }
                if ($market->status == 3){
                     $color = '#1f9402';
                  $statusText = '<span>Opening</span>';
                }
                if ($market->status == 4){
                     $color = '#135e00';
                     $statusText = '<span>Quotation 1/2</span>';
                }
                if ($market->status == 5){
                     $color = '#104800';
                     $statusText = '<span>Quotation 2/2</span>';
                }
                if ($market->status == 6){
                     $color = '#0a2a00';
                     $statusText = '<span>Competition</span>';
                }
                if ($market->status == 7 or $market->status == 8 or $market->status == 9){
                     $color = '#ff0707';
                     $statusText = '<span>Close</span>';
                }
            @endphp
            <input type="hidden" id="previous_status-{{ $market->id }}" value="{{ $market->status }}">


            <tr style="color: {{ $color }} !important;" id="market-{{ $market->id }}"
                data-status="{{ $market->status }}"
                data-difference="{{ $market->difference }}"
                data-now="{{ $now }}"
                data-benchmark1="{{ $market->benchmark1 }}"
                data-benchmark2="{{ $market->benchmark2 }}"
                data-benchmark3="{{ $market->benchmark3 }}"
                data-benchmark4="{{ $market->benchmark4 }}"
                data-benchmark5="{{ $market->benchmark5 }}"
                data-benchmark6="{{ $market->benchmark6 }}"
                data-today-last="{{ $market->is_today_last }}"
            >
                <td class="position-relative">
                    @if(1 <$market->status and  $market->status< 7)
                    <div class="animation_main_div" style="position: absolute;left: 5px;top: -3px">
                        <div class="circle " style="background-color: {{ $color }} !important;"></div>
                        <div class="circle2" style="background-color: {{ $color }} !important;"></div>
                        <div class="circle3" style="background-color: {{ $color }} !important;"></div>
                        <div class="circle4" style="background-color: {{ $color }} !important;"></div>
                        <div class="logo-div-send">
                            <!--logo or anything put here -->
                        </div>
                    </div>
                    @endif
                    <span>
                        {{ $market->SalesForm->commodity }}
                    </span>
                </td>
                <td>
                    {{ $market->SalesForm->max_quantity.'('.$market->SalesForm->unit.')' }}
                </td>
                <td>
                    {{ $market->SalesForm->packing }}
                </td>
                <td>
                    {{ $market->SalesForm->incoterms }}
                </td>
                <td>
                    {{ $market->SalesForm->country }}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($market->date_time)->format('Y-m-d') }}
                </td>
                <td id="market-time-parent-{{ $market->id }}">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="animation_main_div d-none">
                            <div class="circle " style="background-color: #0b2e13 !important;"></div>
                            <div class="circle2" style="background-color: #0b2e13 !important;"></div>
                            <div class="circle3" style="background-color: #0b2e13 !important;"></div>
                            <div class="circle4" style="background-color: #0b2e13 !important;"></div>
                            <div class="logo-div-send">
                                <!--logo or anything put here -->
                            </div>
                        </div>
                        {{--                        <span id="market-time-{{ $market->id }}" style="margin-top: 10px;margin-left: 10px">--}}
                        {{--                            {{ \Carbon\Carbon::parse($market->date_time)->format('H:i') }}--}}
                        {{--                        </span>--}}
                        <span class="{{ $market->status == 1 ? 'timer-bold' : '' }}">
                            {!! $statusText !!}
                        </span>
                    </div>


                </td>
                <td id="slide_more_angle_{{ $market->id }}" onclick="slidemore({{ $market->id }})"
                    class="slide_more_angle cursor-pointer">
                    <div class="d-flex">
                        <span>more</span>
                        <i class="fa fa-angle-down"></i>
                    </div>
                </td>
                <td>
                    <a href="{{ route('home.bid',['market'=>$market->id]) }}" class="btn btn-primary bid-bottom btn-sm">
                        Bid
                    </a>
                </td>
            </tr>
            <tr id="more_table_{{ $market->id }}" style="display: none" class="slide_more_table">
                <td colspan="11">
                    <table class="table_in_table" style="width: 100%">
                        <tr>
                            <td class="text-center">
                                <span class="text-bold">Specification</span>
                                <span>Available</span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Contract Type</span>
                                <span> {{ $market->SalesForm->price_type }}</span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Offer Price</span>
                                <span>
                                    @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="text-bold">Partial Shipment</span>
                                <span>{{ $market->SalesForm->partial_shipment }}</span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Supplier</span>
                                <span>{{ $market->SalesForm->company_type }}</span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Peyment Term</span>
                                <span>
                                    @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="text-bold">Insurance</span>
                                <span>Available</span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Target Market</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->target_market }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="text-bold">Delivery Date</span>
                                <span>
                                    @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="text-bold">Min Order</span>
                                <span>
                                   {{ $market->SalesForm->min_order }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Inspection</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->quality_quantity_inspection }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Documents</span>
                                <span>
                                   @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

