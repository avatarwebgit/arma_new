
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
    <div class="d-flex" >
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
            @if($item->currency=='' or $item->currency==null)
                <div style="font-size: 12px">
                    {{ $item->title_2 }}
                </div>
            @else
                <div style="font-size: 12px">
                    {{ $item->title_2.' ('.$item->currency.')' }}
                </div>
            @endif

        </div>
        <div>
                                    <span style="font-weight: bold" class="d-block text-center {{ $class }}">
                            {{ $item->number_1 }}
                                        @if($item->number_1==null or $item->number_1=='')
                                            {{ $item->number_2 }}
                                        @else
                                            {{ ' - '.$item->number_2 }}
                                        @endif

                                    </span>

            <span style="font-weight: bold" class="d-block  text-center bold {{ $class }}">{{ $number_3 }}</span>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            @if(isset($loop) and  $loop->last)

            @else
                <span class="d-block" style="width: 1px;height: 50%;background-color: white;margin-left: 5px;margin-right: 5px"></span>
            @endif
        </div>
    </div>




