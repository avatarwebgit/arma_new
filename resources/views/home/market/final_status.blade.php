@foreach($bids as $item)
    <tr>
        <td class="text-center">{{ $item->quantity }}</td>
        <td class="text-center">{{ $item->price }}</td>
        <td class="text-center">{{ $item->User->id }}</td>
        <td class="text-center">{{ $item->quantity_win }}</td>
        <td class="text-center">{{ $item->is_win==1 ? 'WIN' : 'LOSE' }}</td>
    </tr>
@endforeach
