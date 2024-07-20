@if(count($markets_groups)>0)
<div class="table-responsive">
    <table id="market_index_table" class="table">
        <thead class="thead-dark">
        <tr>
            <th>
            <span style="margin-left: 45px;width: 100% !important;">
            Commodity
            </span>
            </th>
            <th>
              <span style="text-align: center;margin-left: 35px">
            Quantity
            </span>
            </th>
            <th>
            <span style="text-align: center;margin-left: 50px">
              Packaging
            </span>
            </th>
            <th>
             <span style="width: 90px;margin-left: 0">
            Delivery Term
            </span>
            </th>
            <th>
            <span>
            Region
            </span>
            </th>
            <th>
             <span style="width: 30px;margin-left: 65px">
            Date
            </span>
            </th>
            <th>
                        <span style="margin-left: 45px">

            Time
            </span>
            </th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @php
            $i=0;
        @endphp
        @foreach($markets_groups as $key=>$markets)

            @foreach($markets->sortby('time') as $market)
                @php
                    if ($market->status == 1){
                        $statusText = 'Waiting To Open';
                       $color = '#006';
                       $statusText=Carbon\Carbon::parse($market->time)->format('H:i a');
                    }
                    if ($market->status == 2){
                         $statusText = 'Ready to open';
                         $timer='<span data-id="'.$market->id.'" class="timer_index_difference" id="market-timer-difference-'.$market->id.'"></span>';
                          $timer='<div class="d-flex justify-content-center">'.$timer.'</div>';
                          $statusText=$statusText.'<br>'.$timer;
                         $color = '#1f9402';
                    }
                    if ($market->status == 3){
                         $color = '#1f9402';
                         $statusText = 'Opening';
                         $timer='<span style="margin:0 !important" data-id="'.$market->id.'" class="timer_index_difference" id="market-timer-difference-'.$market->id.'"></span>';
                         $timer='<div class="d-flex justify-content-center">'.$timer.'</div>';
                         $statusText=$statusText.'<br>'.$timer;
                    }
                    if ($market->status == 4){
                         $color = '#1f9402';
                         $statusText = 'Quotation 1/2';
                         $timer='<span style="margin:0 !important" data-id="'.$market->id.'" class="timer_index_difference" id="market-timer-difference-'.$market->id.'"></span>';
                         $timer='<div class="d-flex justify-content-center">'.$timer.'</div>';
                         $statusText=$statusText.'<br>'.$timer;
                    }
                    if ($market->status == 5){
                         $color = '#1f9402';
                         $statusText = 'Quotation 2/2';
                         $timer='<span style="margin:0 !important" data-id="'.$market->id.'" class="timer_index_difference" id="market-timer-difference-'.$market->id.'"></span>';
                         $timer='<div class="d-flex justify-content-center">'.$timer.'</div>';
                         $statusText=$statusText.'<br>'.$timer;
                    }
                    if ($market->status == 6){
                         $color = '#1f9402';
                         $statusText = 'Competition';
                         $timer='<span style="margin:0 !important" data-id="'.$market->id.'" class="timer_index_difference" id="market-timer-difference-'.$market->id.'"></span>';
                         $timer='<div class="d-flex justify-content-center">'.$timer.'</div>';
                         $statusText=$statusText.'<br>'.$timer;
                    }
                    if ($market->status == 7 or $market->status == 8 or $market->status == 9){
                         $color = '#c20000';
                         $statusText = 'Close';
                    }
                    if (\Carbon\Carbon::now()->format('Y-m-d')!=$key){
                         $color = 'black';
                    }
                @endphp
                <input type="hidden" id="previous_status-{{ $market->id }}" value="{{ $market->status }}">

                <tr
{{--                    onclick="window.location.href='{{ route('home.bid',['market'=>$market->id]) }}'"--}}
                    onclick="ShowBidPage({{ $market->id }})"
                    style="color: {{ $color }} !important;cursor: pointer;border-bottom: 2px solid #d9d9d9"
                    id="market-{{ $market->id }};"
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
                    class="{{ $i%2==0 ? 'bg-white' : 'bg-gray' }}"
                >
                    <td class="position-relative">
                        <input type="hidden" id="market-deference-{{ $market->id }}" value="{{ $market->difference }}">
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
                        <span style="margin-left: 20px;width: 100% !important;">
                        {{ $market->SalesForm->commodity }}
                    </span>
                    </td>
                    <td>
                        @php
                            $quantity=$market->SalesForm->max_quantity;
                            $quantity=str_replace(',','',$quantity);
                        @endphp
                        <span>
                        {{ number_format($quantity) }}
                    </span>
                    </td>
                    <td>
                                        <span style="width: 90px;text-align: center">
                    {{ $market->SalesForm->packing }}
                    </span>
                    </td>
                    <td>
                    <span style="margin-left: 2px">
                    {{ $market->SalesForm->incoterms }}
                    </span>
                    </td>
                    <td>
                    <span style="margin-left: 10px">
                    {{ $market->SalesForm->country }}
                    </span>
                    </td>
                    <td>
                    <span style="width: 90px;text-align: center;margin-left: 20px">
                    {{ \Carbon\Carbon::parse($market->date_time)->format('Y-m-d') }}
                    </span>
                    </td>
                    <td id="market-time-parent-{{ $market->id }}">
                        <span style="margin: 0;width: 90px;text-align: center"
                              class="{{ $market->status == 1 ? 'timer-bold' : '' }}">
                            {!! $statusText !!}
                        </span>
                    </td>
                    <td class="slide_more_angle cursor-pointer">
                        <div class="d-flex justify-content-center" id="slide_more_angle_{{ $market->id }}"
                             onclick="slidemore({{ $market->id }},event)">
                        <span style="margin: 0;width: fit-content">
                            more
                        </span>
                            <i class="fa fa-angle-down ml-2 mt-1"></i>
                        </div>
                    </td>
                    <td>
                        <a class="btn btn-primary bid-bottom btn-sm text-white">
                            Bid
                        </a>
                    </td>
                </tr>
                <tr id="more_table_{{ $market->id }}" style="display: none" class="slide_more_table">

                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        @endforeach
        </tbody>
    </table>
</div>
@endif
