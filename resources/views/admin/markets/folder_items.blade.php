<table class="table">
    <thead>
    <tr>

        <th>Account</th>
        <th>Deal ID</th>
        <th>Commodity</th>
        <th>Time</th>
        <th>Market Value</th>
        <th>Bidder</th>
        <th>status</th>
        @unless(request()->is('admin-panel/management/dashboard'))
        <th></th>
        @endunless
    </tr>
    </thead>
    <tbody>
    @foreach($markets->sortBy('time') as $key=>$item)

        {{--                                                @if($item->status==1)--}}
        {{--                                                    @php--}}
        {{--                                                        $show_btn=1;--}}
        {{--                                                    @endphp--}}
        {{--                                                @else--}}
        {{--                                                    @php--}}
        {{--                                                        $show_btn=0;--}}
        {{--                                                    @endphp--}}
        {{--                                                @endif--}}

        @if($item->status==7 or $item->status==8 or $item->status==9)
            @php
                $status_text='close';
                $color='red';
                 $show_btn=0;
            @endphp
        @else
            @php
                $status_text=$item->Status->title;
                $color=$item->Status->color;
                 $show_btn=1;
            @endphp
        @endif
        <tr style="color: {{ $color }}">

            <td>
                @if($item->created_market_by!=null)
                    {{--                                                            {{ 'Armx-'.ucfirst(mb_substr($item->CreatedBy->Roles[0]->name, 0, 1)).(1000+$item->CreatedBy->id) }}--}}
                    {{ $item->CreatedBy->user_id }}
                @else
                    -
                @endif
            </td>
            <td>
                Armx-T{{ $item->id }}
            </td>
            <td>
                {{ $item->SalesForm->commodity }}
            </td>
            {{--                                                    <td>--}}
            {{--                                                        {{ $item->date }}--}}
            {{--                                                    </td>--}}
            <td>
                {{ Carbon\Carbon::parse($item->time)->format('g:i A') }}
            </td>
            <td>
                {{ number_format($item->market_value) }}
            </td>
            {{--                                                    <td>--}}
            {{--                                                        {{ $item->bid_deposit }}--}}
            {{--                                                    </td>--}}
            <td>
                {{--                                                        {{ 'Armx-'.ucfirst(mb_substr($item->SalesForm->User->Roles[0]->name, 0, 1)).(1000+$item->SalesForm->User->id) }}--}}
                @if(isset($item->Participants) && $item->Participants->user_ids!=null)
                    {{ count(unserialize($item->Participants->user_ids)) }}
                @else
                    0
                @endif

            </td>
            <td id="market_status_{{ $item->id }}">
                {{ $status_text }}
            </td>

            @unless(request()->is('admin-panel/management/dashboard'))
                <td>
                    <div class="d-flex justify-content-end">
{{--                        @if($show_btn==1)--}}
                            <a href="{{ route('sale_form.preparation',['item'=>$item->SalesForm->id,'folder'=>$item->date]) }}"
                               class="btn btn-sm btn-warning text-white mr-1">
                                <i class="fa fa-pen"></i>
                                Edit
                            </a>

                            <a title="Edit Market"
                               href="{{ route('admin.market.edit', ['market'=>$item->id]) }}"
                               class="btn btn-sm btn-info ml-2">
                                <i class="fa fa-pen"></i>
                                Market
                            </a>
                            <a title="Bidder"
                               href="{{ route('sale_form.permission',['item'=>$item->id]) }}"
                               class="btn btn-sm btn-success ml-2">
                                <i class="fa fa-plus"></i>
                                Bidder
                            </a>
                            {{--                                                        <button type="button" title="Copy Market"--}}
                            {{--                                                                onclick="copyMarket({{ $item->id }},this)"--}}
                            {{--                                                                class="btn btn-sm btn-secondary">--}}
                            {{--                                                            <div class="loader d-none"></div>--}}
                            {{--                                                            <span>--}}
                            {{--                                                                Copy--}}
                            {{--                                                            </span>--}}
                            {{--                                                        </button>--}}

                            {!! Form::open([
    'method' => 'POST',
    'route' => ['admin.market.remove'],
    'class' => 'd-inline',
    ]) !!}
                            <a href="#"
                               class="btn btn-sm small btn-danger show_confirm ml-2"
                               id="delete-form-{{ $item->id }}"
                               data-bs-toggle="tooltip" data-bs-placement="bottom"
                               title=""
                               data-bs-original-title="{{ __('Delete') }}"><i
                                    class="ti ti-trash mr-1"></i></a>
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            {!! Form::close() !!}
{{--                        @endif--}}
                    </div>
                </td>
            @endunless


        </tr>
    @endforeach
    </tbody>
</table>
