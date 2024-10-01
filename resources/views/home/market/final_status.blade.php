@if(count($bids)>0)
    @foreach($bids as $item)
        <tr style="height: 27px;background-color: #e4e4e4">
                {{--        <td class="text-center">{{ $item->quantity }}</td>--}}
                <td class="text-center">{{ number_format($item->quantity_win) }}</td>
                <td class="text-center">{{ number_format($item->price) }}</td>
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
    @endforeach
@else
    <tr style="height: 27px;background-color: #e4e4e4">
        {{--        <td class="text-center">{{ $item->quantity }}</td>--}}
        <td class="text-center">

                N.A

        </td>
        <td class="text-center">

                N.A

        </td>
        {{--        <td class="text-center">{{ $item->User->id }}</td>--}}
        <td class="text-center">

                N.A

        </td>
    </tr>
@endif

