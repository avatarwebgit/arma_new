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
                            <div id="header2-{{ $item->id }}">
                                @include('home.sections.header2_row')
                            </div>
                        @endforeach

                    @endif
                @endforeach
            @endfor
        </div>
    </div>

</div>

