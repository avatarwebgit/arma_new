@if(count($bids)>0)
    @foreach($bids as $key=>$bid)
        <tr class="@if(auth()->id()===$bid->user_id) btn-info @endif">
            <td class="text-center ">
            <span>
                @auth
                    @if(auth()->id()===$bid->user_id)
                        You
                    @endif
                @endauth
            </span>
            </td>
            <td class="text-center">
                        <span>
                {{ number_format($bid->quantity) }}
           </span>
            </td>
            <td class="text-center">
                {{ number_format($bid->price) }}
                @if($key!=0 )
                    @if($bid->user_id==auth()->id() and $bid->Market->status==3 )

                        <span id="remove_btn_{{ $market->id }}" onclick="removeBid({{ $market->id }},{{ $bid->id }})">
{{--                     <i  class="fa fa-times-circle text-danger"></i>--}}
                            <span style="display: block;padding: 5px 10px;background-color: red;color: white">
                                Delete
                            </span>
                </span>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach

@else
    <tr style="height: 27px">
        <td class="text-center ">

        </td>
        <td class="text-center">

        </td>
        <td class="text-center">

        </td>
    </tr>
@endif

