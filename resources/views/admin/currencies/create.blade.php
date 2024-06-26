@extends('admin.layouts.main')
@section('title', __('New Currency'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('New Currency') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('New Currency') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    {!! Form::open([
        'route' => 'admin.currency.store',
        'method' => 'Post',
        'enctype' => 'multipart/form-data',
    ]) !!}
    <div class="row">

        <div class="form-group col-12 col-md-6">
            <label class="col-form-label" for="title">Title</label>
            <input id="title" type="text" name="title" class="form-control"
                   placeholder="title" value="{{ old('title') }}">
            @error('title')
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>

        <div class="form-group col-12 col-md-6">
            <label class="col-form-label" for="image">Image</label>
            <input id="image" type="file" name="image" class="form-control">
            @error('image')
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>


    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <a href="{{ route('admin.currencies.index') }}" type="button" class="btn btn-secondary" style="margin-right: 5px"
               data-bs-dismiss="modal">{{ __('Back') }}</a>
            {{ Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
        </div>

    </div>
    {!! Form::close() !!}

@endsection
@push('script')

@endpush



