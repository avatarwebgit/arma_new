@foreach($market->Bids as $key=>$item)
    <tr>
        <td class="text-center">{{ $item->quantity }}</td>
        <td class="text-center">{{ $item->price }}</td>
        @if(auth()->user()->hasRole('admin'))
        <td class="text-center">{{ $item->User->id }}</td>
        @endif
    </tr>
@endforeach
