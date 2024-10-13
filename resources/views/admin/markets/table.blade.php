<table class="table text-center">
    <thead class="bg-dark">
    <tr>
        <th>Row</th>
        <th>Date</th>
        <th>Transactions</th>
        <th>Status</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @php
        $i=count($group_markets);
    @endphp
    @foreach($group_markets as $key=>$m)
        @php
            $last_market=\App\Models\Market::where('date',$key)->orderBy('time','desc')->first();
            if (\Carbon\Carbon::now()->format('Y-m-d')==$last_market->date){
                if ($last_market->Status->id<7){
                    $color='green';
                $status_text='Doing';
                $show_delete_btn=0;
                }else{
                $color='red';
                $status_text='Closed';
                $show_delete_btn=0;
                }

            }else{
                $color=$last_market->Status->color;
                $status_text=$last_market->Status->title;
                $show_delete_btn=1;
            }
        @endphp
        <tr onclick="window.location.href='{{ route('admin.markets.folder',['date'=>$key]) }}'"
            style="cursor: pointer;color: {{ $color }}">
            <td>
                {{ $i }}
            </td>
            <td>
                {{ $key }}
            </td>
            <td>
                {{ count($m) }}
            </td>
            <td>
                {{ $status_text=='close' ? 'Closed' : $status_text }}
            </td>
            <td class="text-right">
                @if($last_market->Status->id==7 or $last_market->Status->id==8 or $last_market->Status->id==9 or $show_delete_btn==0)
                @else
                    @if(request()->is('admin-panel/management/dashboard'))

                    @else
                        {!! Form::open([
'method' => 'POST',
'route' => ['admin.market.folder.remove',['date'=>$key]],
'class' => 'd-inline',
]) !!}
                        <a href="#"
                           class="btn btn-sm small btn-danger show_confirm"
                           data-bs-toggle="tooltip" data-bs-placement="bottom"
                           title=""
                           data-bs-original-title="{{ __('Delete') }}"><i
                                class="ti ti-trash mr-1"></i></a>
                        {!! Form::close() !!}
                    @endif

                @endif
            </td>
        </tr>
        @php
            $i--
        @endphp
    @endforeach
    </tbody>
</table>
