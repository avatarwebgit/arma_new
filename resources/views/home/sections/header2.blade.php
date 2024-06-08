<div id="scroll-container2" class="p-2 header2 d-flex scroll-container">
    <div id="scroll-container-first-div2">
        <div class="d-flex" >
            @for($i=0;$i<6;$i++)
                @if($i==0)
                    @php
                        $title='Energy';
                    @endphp

                @elseif($i==1)
                    @php
                        $title='Metal';
                    @endphp

                @elseif($i==2)
                    @php
                        $title='Industrial';
                    @endphp
                @elseif($i==3)
                    @php
                        $title='Agriculture';
                    @endphp
                @elseif($i==4)
                    @php
                        $title='Currency';
                    @endphp
                @else($i==5)
                    @php
                        $title='Crypto';
                    @endphp
                @endif

                @foreach($header2 as $key=>$item)

                    @if($item->number_1>0)
                        @php
                            $class='text-success';
                            $color='green';
                        @endphp
                    @elseif($item->number_1<0)
                        @php
                            $class='text-danger';
                            $color='red';
                        @endphp
                    @else
                        @php
                            $class='text-muted';
                            $color='gray'
                        @endphp
                    @endif
                    <div class="d-flex">
                        @if($key==0)
                            <div class="d-flex justify-content-center align-items-center">
                                <strong class="header_title2 mr-4" style="margin-left: 80px !important;">
                                    {{ $title }}
                                </strong>
                            </div>
                        @endif
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
                                {{ $item->title_2 }}
                            </div>
                        </div>

                        <div>
                            <span class="d-block  text-center {{ $class }}">{{ $item->number_2.' - '.$item->number_1 }}</span>
                            <span class="d-block  text-center {{ $class }}">{{ $item->number_3 }}</span>
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
            @endfor
        </div>
    </div>

</div>

