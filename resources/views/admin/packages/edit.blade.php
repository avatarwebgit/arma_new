@extends('admin.layouts.main')
@section('title', __('Edit Package'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Edit Package') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Edit Package') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <form method="post" action="{{ route('admin.package.update',['package'=>$package->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row">
            <div class="form-group col-12 col-md-6">
                <label class="col-form-label" for="title">title</label>
                <input id="title" type="text" name="title" class="form-control"
                       placeholder="title" value="{{ $package->title }}">
                @error('title')
                <p class="input-error-validate">
                    {{ $message }}
                </p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <a href="{{ route('admin.packages.index') }}" type="button" class="btn btn-secondary" style="margin-right: 5px"
                   data-bs-dismiss="modal">{{ __('Back') }}</a>
                {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
            </div>

        </div>
    </form>
@endsection
@push('script')

@endpush



