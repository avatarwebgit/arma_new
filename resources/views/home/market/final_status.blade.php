@if(isset($bidhistories_groups))
    @foreach($bidhistories_groups as $bidhistories)
        @php
            $bidhistories_qroupedby_quantities=$bidhistories->sortByDesc('quantity')->groupby('quantity');
        @endphp
        @foreach($bidhistories_qroupedby_quantities as $key=>$bidhistories_qroupedby_quantity)
            @foreach($bidhistories_qroupedby_quantity->sortBy('created_at',false) as $item)
                <tr>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-center">{{ $item->price }}</td>
                    <td class="text-center">{{ $item->User->id }}</td>
                    <td class="text-center">{{ $item->id }}</td>
                </tr>
            @endforeach
        @endforeach
    @endforeach

@endif
