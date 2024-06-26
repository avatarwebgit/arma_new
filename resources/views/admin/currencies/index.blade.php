@extends('admin.layouts.main')
@section('title', __('Currencies'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Currencies') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Currencies') }}</li>
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
                            <a href="{{ route('admin.currency.create') }}"
                               class="btn btn-default btn-primary btn-sm no-corner " tabindex="0"
                               aria-controls="users-table"><span><i class="ti ti-plus"></i> Create</span></a>
                        </div>
                        <div class="container-fluid">

                            <table class="table table-striped">
                                <thead>
                                <tr class="bg-dark">
                                    <th>#</th>
                                    <th>title</th>
                                    <th>Image</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($currencies as $key=>$item)
                                    <tr>
                                        <td>
                                            {{ $key+1 }}
                                        </td>
                                        <td>
                                            {{ $item->title }}
                                        </td>
                                        <td>
                                            <div class="text-left position-relative">
                                                <img alt="banner"
                                                     src="{{ imageExist(env('UPLOAD_IMAGE_CURRENCY'),$item->image) }}">
                                            </div>
                                        </td>
                                        <td class="">
                                            {!! Form::open([
'method' => 'POST',
'route' => ['admin.currency.remove', ['id'=>$item->id]],
'id' => 'delete-form-' . $item->id,
'class' => 'd-inline',
]) !!}
                                            <a href="#" class="btn btn-sm small btn-danger show_confirm"
                                               id="delete-form-{{ $item->id }}"
                                               data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                               data-bs-original-title="{{ __('Delete') }}"><i
                                                    class="ti ti-trash mr-1"></i></a>
                                            {!! Form::close() !!}
                                            <a data-action="/admin-panel/management/setting/header1/edit/{{ $item->id }}"
                                               style="margin-left: 10px"
                                               href="{{ route('admin.currency.edit',['currency'=>$item->id]) }}"
                                               class="btn btn-icon btn-primary btn-sm edit-header1">
                                                <i class="ti ti-edit"></i>
                                            </a>
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

@endpush
