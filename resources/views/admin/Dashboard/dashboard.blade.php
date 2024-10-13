@extends('admin.layouts.main')
@section('title', __('Dashboard'))
@section('content')
    <div class="row g-5 g-xl-8">
        @include('admin.dashboard.profile')
        @include('admin.dashboard.markets')
{{--        @include('admin.dashboard.users')--}}
{{--        @include('admin.dashboard.inquiries')--}}
{{--        @include('admin.dashboard.sales_order')--}}
{{--        @include('admin.dashboard.settings')--}}
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('home/css/style.bundle.css') }}">
    <style>
        .dash-content {
            background-color: white;
        }
        .text-white{
            color: white !important;
        }
    </style>
@endpush
@push('script')

@endpush
