<table class="table table-responsive-sm">
    <thead class="thead-dark">
    <tr>
        <th style="width: 10%">Commodity</th>
        <th style="width: 10%">Quantity</th>
        <th style="width: 10%">Packaging</th>
        <th style="width: 10%">Delivery Term</th>
        <th style="width: 10%">Region</th>
        <th style="width: 10%">Date</th>
        <th style="width: 10%">Time</th>
        <th style="width: 10%"></th>
        <th style="width: 10%"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($markets_groups as $key=>$markets)

        @foreach($markets->sortby('time') as $market)
            @php
                if ($market->status == 1){
                    $statusText = '<span>Waiting To Open</span>';
                   $color = '#006';
                   $statusText=Carbon\Carbon::parse($market->time)->format('g:i a');
                }
                if ($market->status == 2){
                     $statusText = '<span>Ready to open</span>';
                     $color = '#1f9402';
                }
                if ($market->status == 3){
                     $color = '#1f9402';
                  $statusText = '<span>Opening</span>';
                }
                if ($market->status == 4){
                     $color = '#1f9402';
                     $statusText = '<span>Quotation 1/2</span>';
                }
                if ($market->status == 5){
                     $color = '#1f9402';
                     $statusText = '<span>Quotation 2/2</span>';
                }
                if ($market->status == 6){
                     $color = '#1f9402';
                     $statusText = '<span>Competition</span>';
                }
                if ($market->status == 7 or $market->status == 8 or $market->status == 9){
                     $color = 'red';
                     $statusText = '<span>Close</span>';
                }
                if (\Carbon\Carbon::now()->format('Y-m-d')!=$key){
                     $color = 'black';
                }
            @endphp
            <input type="hidden" id="previous_status-{{ $market->id }}" value="{{ $market->status }}">

            <tr onclick="window.location.href='{{ route('home.bid',['market'=>$market->id]) }}'"
                style="color: {{ $color }} !important;cursor: pointer" id="market-{{ $market->id }}"
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
                <td style="width: 10%" class="position-relative">
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
                    <span style="display: block;width: 30%;text-align: left;margin:0 auto">
                        {{ $market->SalesForm->commodity }}
                    </span>
                </td>
                <td style="width: 10%">
                    @php
                        $quantity=$market->SalesForm->max_quantity;
                        $quantity=str_replace(',','',$quantity);
                    @endphp
                    <span style="display: block;width: 30%;text-align: left;margin:0 auto">
                        {{ number_format($quantity) }}
                    </span>
                </td>
                <td style="width: 10%">
                                        <span style="display: block;width: 70%;text-align: left;margin-left:35px">
                    {{ $market->SalesForm->packing }}
                    </span>
                </td>
                <td style="width: 10%">
                    <span style="display: block;width: 30%;text-align: left;margin:0 auto">
                    {{ $market->SalesForm->incoterms }}
                    </span>
                </td>
                <td style="width: 10%">
                    <span style="display: block;width: 70%;text-align: left;margin-left:35px">
                    {{ $market->SalesForm->country }}
                    </span>
                </td>
                <td style="width: 10%">
                    <span style="display: block;width: 70%;text-align: left;margin-left:35px">
                    {{ \Carbon\Carbon::parse($market->date_time)->format('Y-m-d') }}
                    </span>
                </td>
                <td style="width: 10%" id="market-time-parent-{{ $market->id }}">
                    <div class="d-flex align-items-center justify-content-center">
                        <span class="{{ $market->status == 1 ? 'timer-bold' : '' }}">
                            {!! $statusText !!}
                        </span>
                    </div>


                </td>
                <td style="width: 10%" class="slide_more_angle cursor-pointer">
                    <div class="d-flex justify-content-center" id="slide_more_angle_{{ $market->id }}"
                         onclick="slidemore({{ $market->id }},event)">
                        <span>more</span>
                        <i class="fa fa-angle-down ml-2 mt-1"></i>
                    </div>
                </td>
                <td style="width: 10%">
                    <a class="btn btn-primary bid-bottom btn-sm text-white">
                        Bid
                    </a>
                </td>
            </tr>
            <tr id="more_table_{{ $market->id }}" style="display: none" class="slide_more_table">
                <td colspan="11">
                    <table class="table_in_table" style="width: 100%">
                        <tr>
                            <td class="text-center">
                                <span class="text-bold">Contract Type</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->contract_type }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Min Order</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->min_order }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="text-bold">Supplier</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->company_type }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>


                        </tr>
                        <tr>
                            <td class="text-center">
                                <span class="text-bold">Specification</span>
                                <span>
                                                                @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                                            </span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Price Type</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->price_type }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-bold">Payment</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->payment }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>

                        </tr>
                        <tr>
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

                            <td class="text-center">
                                <span class="text-bold">Unit</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->unit }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="text-bold">Currency</span>
                                <span>
                                    @auth
                                        {{ $market->SalesForm->currency }}
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

