<div id="scroll-container" class="bg-white header1 d-flex scroll-container">
    <div class="d-flex">
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

            @foreach($header1 as $key=>$item)

                @if($item->number_1>0)
                    @php
                        $class='text-success';
                        $src='home/img/green.png';
                        $img_display=1;
                    @endphp
                @elseif($item->number_1<0)
                    @php
                        $class='text-danger';
                        $src='home/img/Red_triangle.svg.png';
                        $img_display=1;
                    @endphp
                @else
                    @php
                        $class='text-muted';
                        $icon='';
                        $img_display=0;
                    @endphp
                @endif
                @if($item->number_3>0)
                    @php
                        $color='#137713';
                    @endphp
                @elseif($item->number_3<0)
                    @php

                        $color='#dc3545';
                    @endphp
                @else
                    @php
                        $color='#6c757d';
                    @endphp
                @endif
                <div class="d-flex">
                    @if($key==0)
                        <div class="d-flex justify-content-center align-items-center">
                            <strong class="header_title mr-4 ml-5">
                                {{ $title }}
                            </strong>
                        </div>
                    @endif
                    <div>
                        <div style="font-size: 15px">
                            {{ $item->title }}
                        </div>
                        <div style="font-size: 12px">
                            {{ $item->title }}
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center ml-3 mr-3">
                        @if($img_display)
                            <img width="15" src="{{ asset($src) }}">
                        @endif
                    </div>
                    <div>
                        <span class="d-block text-center {{ $class }}">
                            {{ $item->number_2.' - '.$item->number_3 }}
                        </span>
                        <span class="d-block text-center {{ $class }}">
                            {{ $item->number_1 }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        @if($loop->last)

                        @else
                            <span class="d-block"
                                  style="width: 1px;height: 50%;background-color: black;margin-left: 5px;margin-right: 5px"></span>
                        @endif

                    </div>
                </div>
            @endforeach
        @endfor
    </div>
</div>

