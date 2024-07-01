@extends('admin.layouts.main')
@section('title', __('Header 2'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Line 1') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Line 1') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <form enctype="multipart/form-data" method="post" action="{{ route('admin.header1.category.headers.store') }}">
        @csrf
        <div class="row">
            <div class="form-group col-md-4">
                <label class="col-form-label" for="title">Title</label>
                <input id="title" type="text" name="title" class="form-control" value="{{ old('title') }}">
                @error('title')
                <p class="input-error-validate">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label class="col-form-label" for="priority">Priority</label>
                <input id="priority" type="text" name="priority" class="form-control" value="{{ old('priority') }}">
                @error('priority')
                <p class="input-error-validate">
                    {{ $message }}
                </p>
                @enderror
            </div>

        </div>
        <div class="row">
            <div class="col-8 d-flex justify-content-center ">
                <a href="{{ route('admin.header1.index') }}" type="button" class="btn btn-secondary">{{ __('Back') }}</a>
                <button type="submit" class="btn btn-primary" style="margin-left: 5px">
                    Create
                </button>
            </div>

        </div>
    </form>



@endsection
@push('script')

@endpush



