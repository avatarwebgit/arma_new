@if(count($bids)>0)


    @foreach($bids as $key=>$bid)

        @php
            $is_first = 0; 
            $history_exists = \App\Models\MarketHistory::where('bid_id',$bid->id)->exists();
            if($history_exists){
            $history = \App\Models\MarketHistory::where('bid_id',$bid->id)->first();
            $is_first = $history->is_first;
            }
            $best_price = \App\Models\MarketHistory::where('market_id', $market->id)->orderBy('price', 'desc')->first();
            $bid_history_delete= \App\Models\MarketHistory::where('user_id',auth()->user()->id)->where('market_id',$market->id)->where('is_deleted',1)->exists();


        @endphp
        <input type="hidden" value="{{$is_first}}">
        <input type="hidden" value="{{$bid->id}}">
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


                        @php
                            $is_delete = false;
                             $bids = $market->Bids;
                $bid_exists_with_same_price = $bids->filter(function ($other_bid) use ($bid) {
                    return ($other_bid->price == $bid->price) && ($other_bid->id != $bid->id); // مطمئن شویم که خود bid فعلی را در نظر نمی‌گیریم
                })->isNotEmpty();
             

                        @endphp
                        @if(!$bid_exists_with_same_price )
                            @if(!$bid_history_delete)
                                <span data-best-price="{{$bid_exists_with_same_price}}"
                                      id="remove_btn_{{ $market->id }}"
                                      onclick="removeBid({{ $market->id }},{{ $bid->id }})"
                                      style="
                              background: red;
  padding: 2px 9px;
  border-radius: 5px;
  font-size: 7pt;">


                                Delete

                </span>
                            @endif

                        @elseif($is_first == 1 and ($best_price->bid_id != $bid->id))
                            @if(!$bid_history_delete)

                                <span id="remove_btn_{{ $market->id }}"
                                      onclick="removeBid({{ $market->id }},{{ $bid->id }})"
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
                @else
                    @if(count($bids)>1)
                        @if($bid->user_id==auth()->id() and $bid->Market->status==3 )
                            @if($is_first == 1 and ($best_price->bid_id != $bid->id))
                                @if(!$bid_history_delete)
                                    @php
                                        $is_delete = false;
                                         $bids = $market->Bids;
                            $bid_exists_with_same_price = $bids->filter(function ($other_bid) use ($bid) {
                                return $other_bid->price == $bid->price && $other_bid->id != $bid->id; // مطمئن شویم که خود bid فعلی را در نظر نمی‌گیریم
                            })->isNotEmpty();

                                    @endphp
                                    @if(!$bid_exists_with_same_price )
                                        <span id="remove_btn_{{ $market->id }}"
                                              onclick="removeBid({{ $market->id }},{{ $bid->id }})"
                                              style="
                              background: red;
  padding: 2px 9px;
  border-radius: 5px;
  font-size: 7pt;">
{{--                     <i  class="fa fa-times-circle text-danger"></i2>--}}

                                Delete

                </span>
                                    @endif
                                @endif
                            @endif
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

