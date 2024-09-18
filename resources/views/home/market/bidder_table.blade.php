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
                <span onclick="removeBid({{ $market->id }},{{ $bid->id }})">
                     <i  class="fa fa-times-circle text-danger"></i>
                </span>
                @endif
            @endif
        </td>
    </tr>
@endforeach
