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
            <td class="text-center" style="position: relative">
                {{ number_format($bid->price) }}
                @if($key!=0 )
                    @if($bid->user_id==auth()->id() and $bid->Market->status==3 )

                        <span id="remove_btn_{{ $market->id }}" onclick="removeBid({{ $market->id }},{{ $bid->id }})"
                              style="
                              background: red;
  padding: 2px 9px;
  border-radius: 5px;
  font-size: 7pt;
  position: absolute;
  right: 2px;
  bottom: 9px;">
{{--                     <i  class="fa fa-times-circle text-danger"></i>--}}

                                Delete

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

