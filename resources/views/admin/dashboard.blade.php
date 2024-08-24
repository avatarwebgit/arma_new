@extends('admin.layouts.main')
@section('title', __('Dashboard'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title mb-3">
            <h4 class="m-b-10">{{ __('Dashboard') }}</h4>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-header">Users</div>
                                <div class="card-body">
                                    <h5 class="card-title">1200</h5>
                                    <p class="card-text">
                                        User Registered
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-header">Online Users</div>
                                <div class="card-body">
                                    <h5 class="card-title">300</h5>
                                    <p class="card-text">
                                        Users Online
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-danger mb-3">
                                <div class="card-header">
                                    test
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">5</h5>
                                    <p class="card-text">
                                        test
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')

@endpush
@push('script')

@endpush
