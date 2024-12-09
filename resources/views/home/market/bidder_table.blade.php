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
            </td>
            <td class="text-center" style="position: relative">

                @if($key!=0 )
                    @if($bid->user_id==auth()->id() and $bid->Market->status==3 )

                       @if($key!=0 and $bid->user_id==auth()->id())
                        @php
                $is_delete = false;
                 $bid_exists = $market->Bids()->exists();
                    if ($bid_exists) {
                        $highest_price = $market->Bids()->orderBy('price', 'desc')->first();
                        $highest_price = $highest_price->price;
                        if ($bid->price == $highest_price) {
                $is_delete =true;
                       }
                    }

            @endphp
            @if($is_delete)
                        <span id="remove_btn_{{ $market->id }}" onclick="removeBid({{ $market->id }},{{ $bid->id }})"
                              style="
                              background: red;
  padding: 2px 9px;
  border-radius: 5px;
  font-size: 7pt;">
{{--                     <i  class="fa fa-times-circle text-danger"></i>--}}

                                Delete

                </span>
                @endif
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
                <td class="text-center">

        </td>
    </tr>
@endif

