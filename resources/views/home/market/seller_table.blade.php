<tr>
    @php
        $maxQuantity=str_replace(',','',$market->SalesForm->max_quantity);
    @endphp
    <td class="text-center">{{ number_format($maxQuantity) }}</td>
    @if($market->SalesForm->price_type=='Fix')
        <td class="text-center">{{ number_format($market->SalesForm->price) }}</td>
    @else
        <td class="text-center">{{ $market->SalesForm->alpha  }}</td>
    @endif
{{--    <td class="text-center">{{ $market->offer_price }}</td>--}}
</tr>
