<div class="d-flex">
    @for($i=0;$i<5;$i++)
        @foreach($header1_categories as $header1)
            @if(count($header1->Headers)>0)
                <div class="d-flex justify-content-center align-items-center">
                    <strong class="header_title mr-4" style="margin-left: 80px !important;">
                        {{ $header1->title }}
                    </strong>
                </div>

                @foreach($header1->Headers()->orderBy('priority','asc')->where('status',1)->get() as $key=>$item)

                    <div id="header1-{{ $item->id }}-{{ $i }}">
                        @include('home.sections.header1_row')
                    </div>
                @endforeach

            @endif
        @endforeach

    @endfor
</div>

