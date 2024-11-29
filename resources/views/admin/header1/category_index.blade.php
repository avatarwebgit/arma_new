@extends('admin.layouts.main')
@section('title', __('Line 1'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Line 1') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('admin.dashboard'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Line 1') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-5 pb-4">

                        <div class="container-fluid d-flex justify-content-between mb-3">
                            <div>
                                <a href="{{ route('admin.header1.category.headers.create') }}"
                                   class="btn btn-default btn-primary btn-sm no-corner"
                                   tabindex="0"
                                   aria-controls="users-table"><span><i class="ti ti-plus"></i> Create</span></a>
                                <a href="{{ route('admin.dashboard') }}"
                                   class="btn btn-default btn-dark btn-sm no-corner ml5" tabindex="0"
                                   aria-controls="users-table">
                                    <span> Back</span>
                                </a>
                            </div>
                            <div class="w-15">
                                <label>Speed</label>
                                <select onchange="ChangeLineSpeed(1,this)" class="form-control">
                                    <option {{ $speed==2000 ? 'selected' : '' }} value="1500">1</option>
                                    <option {{ $speed==1200 ? 'selected' : '' }} value="1200">2</option>
                                    <option {{ $speed==500 ? 'selected' : '' }} value="700">3</option>
                                    <option {{ $speed==100 ? 'selected' : '' }} value="200">4</option>
                                </select>
                            </div>
                        </div>
                        <div class="container-fluid">

                            <table class="table table-striped">
                                <thead>
                                <tr class="bg-dark">
                                    <th class="w-40">priority</th>
                                    <th>Category</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $key=>$item)
                                    <tr>
                                        <td>
                                            {{ $item->priority }}
                                        </td>
                                        <td>
                                            {{ $item->title }}
                                        </td>
                                        <td class="d-flex justify-content-end">
                                            <a href="{{ route('admin.header1.category.headers.list',['id'=>$item->id]) }}"
                                               class="btn btn-icon btn-dark btn-sm edit-header1 ml5">
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
                                            <a href="{{ route('admin.header1.category.headers.edit',['id'=>$item->id]) }}"
                                               class="btn btn-icon btn-primary btn-sm edit-header1 ml5">
                                                Edit
                                            </a>
                                            {!! Form::open([
'method' => 'POST',
'route' => ['admin.header1.category.headers.remove', $item->id],
'id' => 'delete-form-' . $item->id,
'class' => 'd-inline',
]) !!}
                                            <a href="#" class="btn btn-sm small btn-danger show_confirm ml5"
                                               id="delete-form-{{ $item->id }}"
                                               data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                               data-bs-original-title="{{ __('Delete') }}"><i
                                                    class="ti ti-trash mr-1"></i></a>
                                            {!! Form::close() !!}
                                            <div class="checkbox-wrapper-6 ml5">

                                                <input
                                                    {{ $item->status==1 ? 'checked' : '' }} onchange="CategoryChangeStatus(this,{{ $item->id }})"
                                                    class="tgl tgl-light" id="cb1-{{ $item->id }}" type="checkbox">
                                                <label class="tgl-btn" for="cb1-{{ $item->id }}">

                                                </label>
                                            </div>
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
@endsection
@push('script')
    <script>

        function CategoryChangeStatus(tag, id) {
            let value = $(tag)[0].checked;
            let url = "{{ route('admin.header1.category.change_status') }}"
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

@push('style')
    <style>
        .w-15{
            width: 15%;
        }
    </style>
@endpush
