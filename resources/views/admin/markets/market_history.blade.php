@extends('admin.layouts.main')

@section('title')
    {{ __('History') }}
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Markets').'-'.$date }}</h4>
        </div>
    </div>
@endsection
@section('content')

    <div class="settings mtb15 position-relative">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 mb-3">
                                    <a href="{{ route('admin.markets.index') }}" class="btn btn-sm btn-dark">
                                        Back
                                    </a>

          
                                </div>
                                <div class="col-md-12">
                                    <div class="markets-pair-list">
                                        <div id="alert"></div>
                                      
                                    </div>
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
    <style>
        .modal-content {
            width: 30%;
            margin: 0 auto;
        }

        .ml-2 {
            margin-left: 5px;
        }
    </style>
    @include('admin.layouts.includes.datatable_css')
@endpush
@push('script')
  
@endpush
