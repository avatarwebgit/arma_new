

@extends('admin.layouts.main')
@section('title', __('Line 2'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Line 2') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('admin.dashboard'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Line 2') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-5 pb-4">
                        <div style="padding: 5px 26px;" class="btn-group">
                            <a href="{{ route('admin.header2.create') }}" class="btn btn-default btn-primary btn-sm no-corner"
                               tabindex="0"
                               aria-controls="users-table"><span><i class="ti ti-plus"></i> Create</span></a>
                        </div>
                        <div class="container-fluid">

                            <table class="table table-striped">
                                <thead>
                                <tr class="bg-dark">
                                    <th>Category</th>
                                    <th>priority</th>
                                    <th>Title</th>
{{--                                    <th>Title 2</th>--}}
{{--                                    <th>minimum price</th>--}}
                                    <th>price</th>
                                    <th>changes</th>
                                    <th>Currency</th>
                                    <th>Latest Update</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $rows)

                                    @foreach($rows->sortByDesc('updated_at') as $key=>$item)
                                    <tr>
                                        <td>
                                            @if(count($item->Categories)>0)
                                                @foreach($item->Categories as $category)
                                                    {{ $category->title }}
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->priority }}
                                        </td>
                                        <td>
                                            {{ $item->title }}
                                        </td>
{{--                                        <td>--}}
{{--                                            {{ $item->title_2 }}--}}
{{--                                        </td>--}}

{{--                                        <td class="{{ $item->number_1>0 ? 'text-success' : ($item->number_1<0 ? 'text-danger' : 'text-muted') }}">--}}
{{--                                            {{ $item->number_1 }}--}}
{{--                                        </td>--}}
                                        <td class="{{ $item->number_2>0 ? 'text-success' : ($item->number_2<0 ? 'text-danger' : 'text-muted') }}">
                                            {{ $item->number_2 }}
                                        </td>
                                        <td class="{{ $item->number_3>0 ? 'text-success' : ($item->number_3<0 ? 'text-danger' : 'text-muted') }}">
                                            {{ $item->number_3 }}
                                        </td>
                                        <td>
                                            {{ $item->currency }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->updated_at)->format('Y-m-d') }}
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            {!! Form::open([
'method' => 'POST',
'route' => ['admin.header2.remove', $item->id],
'id' => 'delete-form-' . $item->id,
'class' => 'd-inline',
]) !!}
                                            <a href="#" class="btn btn-sm small btn-danger show_confirm ml5" id="delete-form-{{ $item->id }}"
                                               data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                               data-bs-original-title="{{ __('Delete') }}"><i class="ti ti-trash mr-1"></i></a>
                                            {!! Form::close() !!}
                                            <a style="margin-left: 10px !important;" href="{{ route('admin.header2.edit',['id'=>$item->id]) }}"
                                               class="btn btn-icon btn-primary btn-sm edit-header2 ml5">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <div class="checkbox-wrapper-6 ml5">

                                                <input {{ $item->status==1 ? 'checked' : '' }} onchange="ItemChangeStatus(this,{{ $item->id }})"
                                                       class="tgl tgl-light" id="cb1-{{ $item->id }}" type="checkbox">
                                                <label class="tgl-btn" for="cb1-{{ $item->id }}">

                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('admin.header2.index') }}" type="button" class="btn btn-secondary">{{ __('Back') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        function ItemChangeStatus(tag, id) {
            let value = $(tag)[0].checked;
            let url = "{{ route('admin.header2.change_status') }}"
            $.ajax({
                url: url,
                data: {
                    id: id,
                    value: value,
                    _token: "{{ csrf_token() }}"

                },
                dataType: "json",
                method: "POST",
                success: function (data) {
                    if (data[0] == 0) {
                        alert('error');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                }
            })
        }
    </script>
@endpush
