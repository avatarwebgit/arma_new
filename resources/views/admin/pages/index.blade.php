@extends('admin.layouts.main')

@section('title')
    {{ __('Pages') }}
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Pages') }}</h4>
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
                                        <a href="{{ route('admin.page.create') }}" class="btn btn-primary btn-sm">
                                            Create
                                        </a>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="markets-pair-list">
                                            <div id="alert"></div>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Related Menu</th>
                                                    <th>banner</th>
                                                    <th>date</th>
                                                    <th>action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($pages as $key=>$item)
                                                    <tr>
                                                        <td>
                                                            {{ $key+1 }}
                                                        </td>
                                                        <td>
                                                            {{ $item->title }}
                                                        </td>
                                                        <td>
                                                            @foreach($item->menus as $menu)
                                                                {{ $menu->title }}
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <div class="text-left position-relative">
                                                                <img width="100" alt="banner"
                                                                     src="{{ imageExist(env('UPLOAD_BANNER_PAGE'),$item->banner) }}">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            {{ $item->created_at }}
                                                        </td>
                                                        <td>
                                                            <a title="Edit" href="{{ route('admin.page.edit',['page'=>$item->id]) }}"
                                                               class="btn btn-sm btn-primary">
                                                                <i class="fa fa-list"></i>
                                                                Edit
                                                            </a>
                                                            {!! Form::open([
'method' => 'POST',
'route' => ['admin.page.remove', $item->id],
'class' => 'd-inline',
]) !!}
                                                            <a href="#" class="btn btn-sm small btn-danger show_confirm" id="delete-form-{{ $item->id }}"
                                                               data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                                               data-bs-original-title="{{ __('Delete') }}"><i class="ti ti-trash mr-1"></i></a>
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
                        $('#market_status_'+market_id).text(status_text);
                        $('#market_status_'+market_id).css('color',status_color);
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
