@extends('admin.layouts.main')
@section('title', __('Line 2'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Line 2') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Line 2') }}</li>
        </ul>
    </div>
@endsection
@section('content')

    <form enctype="multipart/form-data" method="post" action="{{ route('admin.header2.category.headers.store') }}">
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
            <div class="col-12">
                <a href="{{ route('admin.header2.index') }}" type="button" class="btn btn-secondary">{{ __('Back') }}</a>
                <button type="submit" class="btn btn-primary" style="margin-left: 5px">
                    Store
                </button>
            </div>

        </div>
    </form>



@endsection
@push('script')

@endpush



