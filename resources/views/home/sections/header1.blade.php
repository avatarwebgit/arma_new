
<div id="scroll-container" class="bg-white header1 d-flex scroll-container">
    @for($i=0;$i<6;$i++)
        <div class="p-3 text-center d-flex">
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

            </strong>
            @foreach($header2 as $item)
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

                <span style="display: inline-block">
                <div class="d-flex align-items-center ml-3">
                    <div class="d-flex align-items-center">
                        <div>
                            <div>
                                <span class="mr-2 header2Title">Crude Oil</span>
                            </div>
                            <div>
                                <span class="mr-2 header2Title">USD/Bbl</span>
                            </div>
                        </div>
                    </div>
                    <div class="ml-4">
                        <span>

        </span>
                    </div>
                    <div style="width: 80px">
                        <div>
                            @if($item->number_2>0)
                                @php
                                    $class='text-success';
                                @endphp
                            @elseif($item->number_2<0)
                                @php
                                    $class='text-danger';
                                @endphp
                            @else
                                @php
                                    $class='text-muted';
                                @endphp
                            @endif
                <span class="{{ $class }} d-block text-right">70.023</span>
                            @if($item->number_1>0)
                                @php
                                    $class='text-success';
                                @endphp
                            @elseif($item->number_1<0)
                                @php
                                    $class='text-danger';
                                @endphp
                            @else
                                @php
                                    $class='text-muted';
                                @endphp
                            @endif
                <span class="{{ $class }} d-flex justify-content-between align-items-center">
                    <i class="fa fa-caret-down fa-2x mr-2 {{ $class }}"></i>
                    0.0120

                </span>
                        </div>
                    </div>
                    <span class="header2Pi">|</span>
                </div>

        </span>
            @endforeach
        </div>
    @endfor

</div>

