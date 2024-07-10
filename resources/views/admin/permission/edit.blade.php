@extends('admin.layouts.main')
@section('title', __('Permission'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Permission') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item">{!! Html::link(route('admin.forms.index'), __('Permission'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Create Permission') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.permission.update',['permission'=>$permission->id]) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" class="form-control" name="name" value="{{ $permission->name }}">
                                    @error('name')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="group">Group</label>
                                    <input id="group" class="form-control" name="group" value="{{ $permission->group }}">
                                    @error('group')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="display_name">Display Name</label>
                                    <input id="display_name" class="form-control" name="display_name" value="{{ $permission->display_name }}">
                                    @error('display_name')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="float-end">
                                    {!! Html::link(route('admin.permission.index'), __('Back'), ['class' => 'btn btn-secondary']) !!}
                                    <button class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

