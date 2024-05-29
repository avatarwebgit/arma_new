@if(count($bids)>0)
    @foreach($bids as $item)
        @if($item->is_win==1)
            <tr>
                {{--        <td class="text-center">{{ $item->quantity }}</td>--}}
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-center">{{ $item->price }}</td>
                {{--        <td class="text-center">{{ $item->User->id }}</td>--}}
                <td class="text-center">
                    @if($item->is_win==1)
                        <span class="text-success">
                    <i class="fa fa-check-circle"></i>
                </span>
                    @else
                        <span class="text-danger">
                    <i class="fa fa-times-circle"></i>
                </span>
                @endif
            </tr>
        @endif
    @endforeach
@else
    <tr>
        {{--        <td class="text-center">{{ $item->quantity }}</td>--}}
        <td class="text-center">-</td>
        <td class="text-center">-</td>
        {{--        <td class="text-center">{{ $item->User->id }}</td>--}}
        <td class="text-center">
            failed
        </td>
    </tr>
@endif

