@extends('admin.layouts.main')

@section('title')
    {{ __('Markets') }}
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Markets').'-'.$date }}</h4>
        </div>
    </div>
@endsection
@section('content')

    <div class="settings mtb15 position-relative">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 mb-3">
                                    <a href="{{ route('admin.markets.index') }}" class="btn btn-sm btn-dark">
                                        Back
                                    </a>
                                    {{--                                        <a href="{{ route('admin.market.create') }}" class="btn btn-primary btn-sm">--}}
                                    {{--                                            Create--}}
                                    {{--                                        </a>--}}
                                </div>
                                <div class="col-md-12">
                                    <div class="markets-pair-list">
                                        <div id="alert"></div>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>commodity</th>
                                                <th>User</th>
                                                <th>date</th>
                                                <th>Time</th>
                                                <th>status</th>
                                                <th>Market Value ($)</th>
                                                <th>action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($markets->sortBy('time') as $key=>$item)
                                                <tr>
                                                    <td>
                                                        {{ $key }}
                                                    </td>
                                                    <td>
                                                        {{ $item->SalesForm->commodity }}
                                                    </td>
                                                    <td>
                                                        {{ $item->SalesForm->User->name }}
                                                    </td>
                                                    <td>
                                                        {{ $item->date }}
                                                    </td>
                                                    <td>
                                                        {{ $item->time }}
                                                    </td>
                                                    @if($item->status==8 or $item->status==9)
                                                        <td id="market_status_{{ $item->id }}"
                                                            style="color: red">
                                                            close
                                                        </td>
                                                    @else
                                                        <td id="market_status_{{ $item->id }}"
                                                            style="color: {{ $item->Status->color }}">

                                                            {{ $item->Status->title }}
                                                        </td>
                                                    @endif
                                                    <td>
                                                        {{ $item->market_value }}
                                                    </td>
                                                    <td>
                                                        <a title="Edit Market"
                                                           href="{{ route('admin.market.edit', ['market'=>$item->id]) }}"
                                                           class="btn btn-sm btn-info">
                                                            <i class="fa fa-pen"></i>
                                                            Market
                                                        </a>
                                                        <a title="Edit Commodity"
                                                           href="{{ route('sale_form',['page_type'=>'Edit','item'=>$item->commodity_id]) }}"
                                                           class="btn btn-sm btn-primary">
                                                            <i class="fa fa-list"></i>
                                                            Commodity
                                                        </a>
                                                        <button type="button" title="Copy Market"
                                                                onclick="copyMarket({{ $item->id }},this)"
                                                                class="btn btn-sm btn-secondary">
                                                            <div class="loader d-none"></div>
                                                            <span>
                                                                Copy
                                                            </span>
                                                        </button>

                                                        {!! Form::open([
'method' => 'POST',
'route' => ['admin.market.remove'],
'class' => 'd-inline',
]) !!}
                                                        <a href="#" class="btn btn-sm small btn-danger show_confirm"
                                                           id="delete-form-{{ $item->id }}"
                                                           data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                                           data-bs-original-title="{{ __('Delete') }}"><i
                                                                class="ti ti-trash mr-1"></i></a>
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        {!! Form::close() !!}
                                                    </td>
                                                </tr>
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
    <div id="copied_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p id="copy_modal_msg">
                        Market Copied Successfully
                    </p>
                </div>
            </div>
        </div>
    </div>
    @include('admin.sections.remove_modal')
@endsection
@push('style')
    <style>
        .modal-content{
            width: 30%;
            margin: 0 auto;
        }
    </style>
    @include('admin.layouts.includes.datatable_css')
@endpush
@push('script')
    <script>
        function copyMarket(market_id, tag) {
            let loader = $(tag).find('.loader');
            let span = $(tag).find('span');
            $.ajax({
                url: "{{ route('admin.market.copy') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    market_id: market_id,
                },
                method: "POST",
                dataType: "json",
                beforeSend: function (msg) {
                    loader.removeClass('d-none');
                    span.addClass('d-none');
                    $(tag).prop('disabled', true);
                },
                success: function (msg) {
                    $('#copied_modal').modal('show');
                    if (msg[0]==1){
                        setTimeout(function() {
                            window.location.reload();
                        },2000)
                    }else {
                        $('#copy_modal_msg').text(msg[1]);
                    }


                }
            })
        }
    </script>
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
