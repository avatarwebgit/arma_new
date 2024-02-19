<div id="scroll-container2" class="header2 d-flex">
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
                        <span style="width: 35px;height: 35px;border-radius: 100%;background-color: {{ $color }}"></span>
                    </div>
                    <div class="ml-2 mr-2">
                        <span class="d-block text-left">{{ $item->title }}</span>
                        <span class="d-block text-left text-secondary">{{ $item->title_2 }}</span>
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
                <span class="{{ $class }}">{{ $item->number_2 }}</span>
                             <span>-</span>
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
                <span class="{{ $class }}">{{ $item->number_1 }}</span>
                        </div>
                        <div class="text-center">
                            @if($item->number_3>0)
                                @php
                                    $class='text-success';
                                @endphp
                            @elseif($item->number_3<0)
                                @php
                                    $class='text-danger';
                                @endphp
                            @else
                                @php
                                    $class='text-muted';
                                @endphp
                            @endif
                <span class="{{ $class }}">{{ $item->number_3 }}</span>
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
                        <span style="width: 35px;height: 35px;border-radius: 100%;background-color: {{ $color }}"></span>
                    </div>
                    <div class="ml-2 mr-2">
                        <span class="d-block text-left">{{ $item->title }}</span>
                        <span class="d-block text-left text-secondary">{{ $item->title_2 }}</span>
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
                <span class="{{ $class }}">{{ $item->number_2 }}</span>
                             <span>-</span>
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
                <span class="{{ $class }}">{{ $item->number_1 }}</span>
                        </div>
                        <div class="text-center">
                            @if($item->number_3>0)
                                @php
                                    $class='text-success';
                                @endphp
                            @elseif($item->number_3<0)
                                @php
                                    $class='text-danger';
                                @endphp
                            @else
                                @php
                                    $class='text-muted';
                                @endphp
                            @endif
                <span class="{{ $class }}">{{ $item->number_3 }}</span>
                        </div>
                    </div>
                    <span class="header2Pi">|</span>
                </div>

        </span>
            @endforeach
    </div>
</div>
