@extends('admin.layouts.main')
@section('title', __('Header 2'))
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
                    <a href="{{ route('admin.header1.index') }}" type="button" class="btn btn-dark btn-sm"
                       style="margin-right: 5px"
                       data-bs-dismiss="modal">{{ __('Back') }}</a>
                    {!! Form::open([
                        'route' => 'admin.header1.store',
                        'method' => 'Post',
                        'enctype' => 'multipart/form-data',
                    ]) !!}

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="col-form-label" for="cat_id">Category</label>
                            <select id="cat_id" name="cat_id" class="form-control">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option
                                        {{ $cat==$category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <p class="input-error-validate">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label" for="title">Title 1 </label>
                            <input id="title" type="text" name="title" class="form-control" value="{{ old('title') }}">
                            @error('title')
                            <p class="input-error-validate">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-form-label" for="title_2">Title 2</label>
                            <input id="title_2" type="text" name="title_2" class="form-control"
                                   value="{{ old('title_2') }}">
                            @error('title_2')
                            <p class="input-error-validate">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        {{--        <div class="form-group col-md-4">--}}
                        {{--            <label class="col-form-label" for="number_1">Minimum price</label>--}}
                        {{--            <input id="number_1" type="text" name="number_1" class="form-control"--}}
                        {{--                    value="{{ old('number_1') }}">--}}
                        {{--            @error('number_1')--}}
                        {{--            <p class="input-error-validate">--}}
                        {{--                {{ $message }}--}}
                        {{--            </p>--}}
                        {{--            @enderror--}}
                        {{--        </div>--}}
                        <div class="form-group col-md-6">
                            <label class="col-form-label" for="number_2">Price</label>
                            <input id="number_2" type="text" name="number_2" class="form-control"
                                   value="{{ old('number_2') }}">
                            @error('number_2')
                            <p class="input-error-validate">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label" for="number_3">Changes</label>
                            <input id="number_3" type="text" name="number_3" class="form-control"
                                   value="{{ old('number_3') }}">
                            @error('number_3')
                            <p class="input-error-validate">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label" for="currency">Currency</label>
                            <input id="currency" name="currency" class="form-control" value="">
                            @error('currency')
                            <p class="input-error-validate">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label" for="priority">priority</label>
                            <input id="priority" type="text" name="priority" class="form-control"
                                   value="{{ old('priority') }}">
                            @error('priority')
                            <p class="input-error-validate">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            {{ Form::button(__('Create'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        </div>

                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')

@endpush



