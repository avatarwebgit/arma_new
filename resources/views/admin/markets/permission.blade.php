@extends('admin.layouts.main')

@section('title')
    {{ __('Markets') }}
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Market Participants') }}</h4>
        </div>
    </div>
@endsection
@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div>
                        <div class="card">
                            <div class="card-body">
                                <div class="col-md-12 mb-3">

                                    <a href="{{ route('admin.markets.folder',['date'=>$market->date]) }}"
                                       class="btn btn-default btn-dark btn-sm no-corner ml5" tabindex="0"
                                       aria-controls="users-table">
                                        <span> Back</span></a>
                                    <button onclick="ShowAddModal()" class="btn btn-success btn-sm">
                                        <i class="fa fa-plus"></i>
                                        Add
                                    </button>
                                </div>
                                <div class="col-md-12 mb-3 d-flex justify-content-between">
                                    @foreach($roles as $role)
                                        <div class="d-flex">
                                            <span>{{ 'All '.ucfirst($role->name) }}</span>
                                            <div class="checkbox-wrapper-6 ml5">
                                                <input
                                                    {{ in_array($role->id,$role_ids) ? 'checked' : '' }} data-id="{{ $role->id }}"
                                                    class="tgl tgl-light checkbox" id="cb1-{{ $role->id }}"
                                                    type="checkbox" onchange="rolePermission({{ $market_id }})">
                                                <label class="tgl-btn" for="cb1-{{ $role->id }}">
                                                </label>
                                            </div>
                                        </div>

                                    @endforeach
                                </div>
                                <div class="col-md-12">
                                    <div class="markets-pair-list">
                                        <div id="alert"></div>
                                        <table class="table">
                                            <thead class="bg-dark">
                                            <tr>
                                                <th>Account</th>
                                                <th>Date</th>
                                                <th>User Type</th>
                                                <th>User ID</th>
                                                <th>Email</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="permission_users">
                                            @include('admin.markets.permission_users')
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
    @include('admin.sections.remove_modal')

    <div class="modal fade" id="ShowAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
         aria-hidden="true">
        <div style="max-width: 500px" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>
                        Add User
                    </h3>
                    <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"></i>
                </div>
                <div class="modal-body p-5 row text-center">
                    <div class="text-left">
                        <label for="search_user" class="mb-2">Select User</label>
                        <select class="form-control" id="search_user" data-live-search="true">
                            @foreach($all_users as $item)
                                <option value="{{ $item->id }}">{{ $item->email }}</option>
                            @endforeach
                        </select>
                        <p id="user_error" class="d-none input-error-validate">select a user</p>
                    </div>
                    <div class="d-flex mt-1">
                        <button class="btn btn-sm btn-success" onclick="SaveUserMarketPermission({{ $market_id }})">
                            Save
                        </button>
                        <button class="btn btn-sm btn-danger me-2" data-dismiss="modal" aria-label="Close">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('style')
    <style>
        .text-left {
            text-align: left !important;
        }

    </style>
@endpush
@push('script')
    <script>
        function rolePermission(market_id) {
            let checkbox = $('.checkbox');
            let role_ids = [];
            $.each(checkbox, function (index, val) {
                let checked = $(val)[0].checked;
                let id = $(val).data('id');
                if (checked) {
                    role_ids.push(id);
                }
            });


            let url = "{{ route('sale_form.store_roles') }}"
            $.ajax({
                url: url,
                data: {
                    market_id: market_id,
                    role_ids: role_ids,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                method: "POST",
                success: function (data) {
                    if (data[0] == 1) {
                        $('#permission_users').html(data[1]);
                    } else {
                        alert('something went wrong')
                    }
                }
            })
        }

        function SaveUserMarketPermission(market_id) {
            $('#user_error').addClass('d-none');
            let user_id = $('#search_user').val();
            if (user_id.length == 0) {
                $('#user_error').removeClass('d-none');
                return false;
            }
            let url = "{{ route('sale_form.store_ids') }}"
            $.ajax({
                url: url,
                data: {
                    market_id: market_id,
                    user_id: user_id,
                    _token: "{{ csrf_token() }}"

                },
                dataType: "json",
                method: "POST",
                success: function (data) {
                    if (data[0] == 1) {
                        window.location.reload();
                    } else {
                        alert('something went wrong')
                    }
                }
            })
        }

        function ShowAddModal() {
            $('#user_error').addClass('d-none');
            let ShowAddModal = $('#ShowAddModal');
            ShowAddModal.modal('show');
        }

        $('select').selectpicker({
            'title': 'Select'
        });

    </script>
@endpush
