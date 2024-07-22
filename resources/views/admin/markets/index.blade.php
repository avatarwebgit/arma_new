@extends('admin.layouts.main')

@section('title')
    {{ __('Markets') }}
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Markets') }}</h4>
        </div>
    </div>
@endsection
@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 mb-3">
                                    <button onclick="createMarketModal()" class="btn btn-primary btn-sm">
                                        Create
                                    </button>
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="btn btn-default btn-dark btn-sm no-corner ml5" tabindex="0"
                                       aria-controls="users-table">
                                        <span> Back</span></a>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="markets-pair-list">
                                            <div id="alert"></div>
                                            <table class="table">
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
                                                            $color='green';
                                                            $status_text='Doing';
                                                            $show_delete_btn=0;
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
                                                            {{ $status_text }}
                                                        </td>
                                                        <td class="text-right">
                                                            @if($last_market->Status->id==7 or $last_market->Status->id==8 or $last_market->Status->id==9 or $show_delete_btn==0)
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
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $i--
                                                    @endphp
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.sections.remove_modal')

@endsection
@push('style')
    @include('admin.layouts.includes.datatable_css')
@endpush
@push('script')
    <script type="module">

        window.Echo.channel('market-status-updated')
            .listen('MarketStatusUpdated', function (e) {
                let market_id = e.market_id;
                get_market_info(market_id)
            });

        function get_market_info(market_id) {

            $.ajax({
                url: "{{ route('home.get_market_info') }}",
                dataType: "json",
                method: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    market_id: market_id,
                },
                success: function (msg) {
                    if (msg[0] === 1) {
                        console.log(msg);
                        let status_text = msg[1];
                        let status_color = msg[2];
                        $('#market_status_' + market_id).text(status_text);
                        $('#market_status_' + market_id).css('color', status_color);
                    }
                }
            })
        }


        function removeModal(id, e) {
            e.stopPropagation();
            let remove_modal = $('#remove_modal');
            $('#id').val(id);
            remove_modal.modal('show');
        }

        function Remove() {
            let id = $('#id').val();
            $.ajax({
                url: "{{ route('admin.market.remove') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                dataType: "json",
                method: "post",
                beforeSend: function () {

                },
                success: function (msg) {
                    if (msg) {
                        $('#remove_modal').modal('hide');
                        if (msg[0] == 1) {
                            window.location.reload();
                        } else {
                            $('#alert').html(msg[1]);
                        }
                    }
                }
            })
        }
    </script>
@endpush
