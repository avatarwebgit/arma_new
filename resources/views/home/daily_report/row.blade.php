@php
    $groupedMarkets = $markets->groupBy('date');
@endphp

@foreach($groupedMarkets as $date => $marketsByDate)
    @foreach($marketsByDate->sortByDesc('time') as $market)
        @php
            $bid = $market->Bids()->orderBy('price', 'desc')->first();
            $has_winner = $market->Bids()->where('is_win', 1)->exists();

            if ($bid){
                $highest=$bid->price;
                if ($market->SalesForm->price_type === 'Fix'){
                    $offer_price=$market->SalesForm->price;
                }else{
                    $offer_price=$market->SalesForm->alpha;
                }
                if ($offer_price<$highest){
                    $has_winner=true;
                }
            }

            if ($bid){
                $quantity_show=$bid->quantity;
            if ($has_winner){
                $quantity_show=$market->Bids()->where('is_win', 1)->sum('quantity');
            }
            }else{
                $quantity_show=null;
            }

             $status_color = $has_winner ? 'green' : 'red';
            $status_text = $has_winner ? 'Done' : 'Failed';
            $unit = $market->SalesForm->unit === 'other' ? $market->SalesForm->unit_other : $market->SalesForm->unit;
            $currency = $market->SalesForm->currency === 'other' ? $market->SalesForm->currency_other . '/' . $unit : $market->SalesForm->currency . '/' . $unit;
            $highest = $bid ? number_format($bid->price) . ' ' . $currency : 'n/a';
            $quantity = $bid ? number_format($quantity_show) . ' ' . $unit : 'n/a';
            $minQuantity = str_replace(',', '', $market->SalesForm->min_order);
            $marketDateTime = $market->date;
        @endphp

        @if($market->date !== $today || $market->time < $time)
            <tr
                style="cursor: pointer"
                onclick="ShowBidPage({{ $market->id }})"
                class="{{ $status_color }}">
                <td>{{ $marketDateTime }}</td>
                <td>{{ \Carbon\Carbon::parse($market->time)->format('H:i') }}</td>

                <td>{{ $market->SalesForm->commodity }}</td>
                <td>{{ $market->SalesForm->max_quantity . ' ' . $unit }}</td>
                <td>{{ number_format($minQuantity) . ' ' . $unit }}</td>
                <td>{{ $market->SalesForm->packing }}</td>
                <td>{{ $market->SalesForm->incoterms }}</td>
                <td>{{ $market->SalesForm->origin_country }}</td>
                <td>{{ $market->SalesForm->price_type }}</td>
                <td>
                    {{ $market->SalesForm->price_type === 'Fix' ? number_format($market->SalesForm->price) . ' ' . $currency : number_format($market->SalesForm->alpha) . ' ' . $currency }}
                </td>
                <td>{{ $highest }}</td>
                <td>{{ $quantity }}</td>
                <td>{{ $status_text }}</td>
            </tr>
        @endif
    @endforeach
@endforeach
