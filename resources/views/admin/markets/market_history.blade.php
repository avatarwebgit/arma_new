@extends('admin.layouts.main')

@section('title')
    {{ __('History') }}
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">Markets History</h4>
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
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>User</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Tries</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bids as $bid)
                                                <tr>
                                                    <td>{{$bid->User->full_name ?? $bid->User->company_name}}</td>
                                                    <td>{{$bid->price}}</td>
                                                    <td>{{$bid->quantity}}</td>
                                                    <td>{{$bid->tries}}</td>
                                                    <td>
                                                        <span class="{{$bid->is_win ? 'text-success' : 'text-danger'}}">
                                                            {{$bid->is_win ? 'Win' : 'Lose' }}
                                                        </span>
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
