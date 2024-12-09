@foreach($bids as $key=>$bid)
    <tr>
        <td class="text-center">{{ $bid->quantity }}</td>
        <td class="text-center">{{ $bid->price }}</td>
        <td class="text-center">
            @if($bid->Market->status==3)

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
                    <span class="remove_function" onclick="removeBid({{ $bid->id }})">
                         <i  class="fa fa-times-circle text-danger"></i>
                    </span>
            @endif

                @endif
            @endif

        </td>
    </tr>
@endforeach
