@if($item->number_3>0)
    @php
        $class='text-success';
        $src='home/img/green.png';
        $img_display=1;
    @endphp
@elseif($item->number_3<0)
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
        $number3='+'.$item->number_3;
        $color='#137713';
    @endphp
@elseif($item->number_3<0)
    @php
        $number3=$item->number_3;
        $color='#dc3545';
    @endphp
@else
    @php
        $number3=$item->number_3;
        $color='#6c757d';
    @endphp
@endif
@if($item->status==1)
    <div class="d-flex" >
        <div>
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
        <div class="d-flex align-items-center justify-content-center ml-3 mr-3">
            @if($img_display)
                <img width="15" src="{{ asset($src) }}">
            @endif
        </div>
        <div>

                                        <span class="d-block text-center {{ $class }}">
{{--                            {{ $item->number_1 }}--}}
{{--                                            @if($item->number_1==null or $item->number_1=='')--}}
                                                {{ $item->number_2 }}
{{--                                            @else--}}
{{--                                                {{ ' - '.$item->number_2 }}--}}
{{--                                            @endif--}}

                        </span>


            <span class="d-block text-center {{ $class }}">
                            {{ $number3 }}
                        </span>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            @if(isset($loop) and $loop->last)

            @else
                <span class="d-block"
                      style="width: 1px;height: 50%;background-color: black;margin-left: 5px;margin-right: 5px"></span>
            @endif

        </div>
    </div>
@endif




