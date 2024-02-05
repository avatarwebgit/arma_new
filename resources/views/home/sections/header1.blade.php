
<div id="scroll-container" class="bg-white header1 d-flex scroll-container">
    <div class="p-3 text-center">
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
                <div class="d-flex align-items-center">
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
            <i class="fa fa-caret-down fa-2x" style="color: {{ $color }}"></i>
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
                <span class="{{ $class }}">70.023</span>
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
                <span class="{{ $class }}">0.0120</span>
                        </div>
                    </div>
                    <span class="header2Pi">|</span>
                </div>

        </span>
        @endforeach
    </div>
    <div class="p-3 text-center">
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
                <div class="d-flex align-items-center">
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
            <i class="fa fa-caret-down fa-2x" style="color: {{ $color }}"></i>
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
                <span class="{{ $class }}">70.023</span>
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
                <span class="{{ $class }}">0.0120</span>
                        </div>
                    </div>
                    <span class="header2Pi">|</span>
                </div>

        </span>
        @endforeach
    </div>
</div>

