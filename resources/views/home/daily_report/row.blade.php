@php
    $groupedMarkets = $markets->groupBy('date');
@endphp

@foreach($groupedMarkets as $date => $marketsByDate)
    @foreach($marketsByDate->sortBy('time') as $market)
        @php
            $bid = $market->Bids()->orderBy('price', 'desc')->first();
            $has_winner = $market->Bids()->where('is_win', 1)->exists();
            $status_color = $has_winner ? 'green' : 'red';
            $status_text = $has_winner ? 'Done' : 'Failed';
            $unit = $market->SalesForm->unit === 'other' ? $market->SalesForm->unit_other : $market->SalesForm->unit;
            $currency = $market->SalesForm->currency === 'other' ? $market->SalesForm->currency_other . '/' . $unit : $market->SalesForm->currency . '/' . $unit;
            $highest = $bid ? number_format($bid->price) . ' ' . $currency : 'n/a';
            $quantity = $bid ? number_format($bid->quantity) . ' ' . $unit : 'n/a';
            $minQuantity = str_replace(',', '', $market->SalesForm->min_order);
        @endphp
        <tr class="{{ $status_color }}">
            <td>{{ $market->date.' '.$market->time }}</td>
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
    @endforeach
@endforeach

