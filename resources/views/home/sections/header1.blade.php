
<div id="scroll-container" class="bg-white header1 d-flex scroll-container">
    @for($i=0;$i<1;$i++)
        <div class="p-1 text-center d-flex">
            <strong class="header_title">
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
                {{ $title }}
            </strong>
            @foreach($header1 as $item)
                @if($item->number_1>0)
                    @php
                        $class='text-success';
                        $icon='<i class="fa fa-caret-up fa-2x mr-2 text-success"></i>';
                    @endphp
                @elseif($item->number_1<0)
                    @php
                        $class='text-danger';
                        $icon='<i class="fa fa-caret-down fa-2x mr-2 text-danger"></i>';
                    @endphp
                @else
                    @php
                        $class='text-muted';
                        $icon='';
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

                <span style="display: inline-block;border-right: 1px solid black">
                <div class="d-flex align-items-center ml-3">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="text-left">
                                <span class="mr-2 header2Title">{{ $item->title }}</span>
                            </div>
                            <div class="text-left">
                                <span class="mr-2 header2Title font13">USD/Bbl</span>
                            </div>
                        </div>
                    </div>
                    <div class="ml-4">
                        <span>

        </span>
                    </div>
                    <div style="width: 80px">
                        <div class="d-flex justify-content-center">
                            <div class="d-flex align-items-center">
                               {!! $icon !!}
                            </div>
 <div>


                <span class="d-flex justify-content-center align-items-center">

                    {{ $item->number_2.'-'.$item->number_3 }}
                </span>

                <span class="{{ $class }} d-flex justify-content-center align-items-center">
                    {{ $item->number_1 }}
                </span>
                            </div>
                        </div>

                    </div>
                    <span class="header2Pi"></span>
                </div>

        </span>
            @endforeach
        </div>
    @endfor

</div>

