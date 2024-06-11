<div id="scroll-container2" class="p-2 header2 d-flex scroll-container">
    <div id="scroll-container-first-div2">
        <div class="d-flex">
            @for($i=0;$i<10;$i++)
            @foreach($header2_categories as $header2)
                @if(count($header2->Headers)>0)
                    <div class="d-flex justify-content-center align-items-center">
                        <strong class="header_title2 mr-4" style="margin-left: 80px !important;">
                            {{ $header2->title }}
                        </strong>
                    </div>
                    @foreach($header2->Headers()->orderBy('priority','asc')->get() as $key=>$item)
                        @if($item->number_3>0)
                            @php
                                $class='text-success';
                                $color='green';
                                $number_3='+'.$item->number_3;
                            @endphp
                        @elseif($item->number_3<0)
                            @php
                                $class='text-danger';
                                $color='red';
                                $number_3=$item->number_3;
                            @endphp
                        @else
                            @php
                                $class='white';
                                $color='gray';
                                $number_3=$item->number_3;
                            @endphp
                        @endif
                        <div class="d-flex">
                            <div class="animation_main_div">
                                <div class="circle " style="background-color: {{ $color }} !important;"></div>
                                <div class="circle2" style="background-color: {{ $color }} !important;"></div>
                                <div class="circle3" style="background-color: {{ $color }} !important;"></div>
                                <div class="circle4" style="background-color: {{ $color }} !important;"></div>
                                <div class="logo-div-send">
                                    <!--logo or anything put here -->
                                </div>
                            </div>
                            <div class="ml-2 mr-2">
                                <div style="font-size: 15px">
                                    {{ $item->title }}
                                </div>
                                <div style="font-size: 12px">
                                    {{ $item->title_2.' ('.$item->currency.')' }}
                                </div>
                            </div>
                            <div>
                                <span style="font-weight: bold" class="d-block  text-center {{ $class }}">{{ number_format($item->number_1,2).' - '.number_format($item->number_2,2) }}</span>
                                <span style="font-weight: bold" class="d-block  text-center bold {{ $class }}">{{ $number_3 }}</span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center">
                                @if($loop->last)

                                @else
                                    <span class="d-block"
                                          style="width: 1px;height: 50%;background-color: white;margin-left: 5px;margin-right: 5px"></span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach
            @endfor
        </div>
    </div>

</div>

