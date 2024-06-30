@extends('admin.layouts.main')

@section('title')
    Refund Requests
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <ul class="breadcrumb mt-3">
            <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
            <li class="breadcrumb-item active">{{ __('Users') }}</li>
            <li class="breadcrumb-item active">{{ __('Refund Requests') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div>
                <div>
                    <div class="card">
                        <div class="card-body">

                            <div class="col-md-12">
                                <div class="markets-pair-list">
                                    <div id="alert"></div>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>amount($)</th>
                                            <th>status</th>
                                            <th>Update</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($items as $key=>$item)
                                            <tr>
                                                <td>
                                                    {{ $key }}
                                                </td>
                                                <td>
                                                    {{ $item->User->email }}
                                                </td>
                                                <td>
                                                    {{ number_format($item->amount) }}
                                                </td>
                                                <td>
                                                    {{ $item->Status->title }}
                                                </td>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i:s') }}
                                                </td>
                                                <td>
                                                    <button onclick="update_status({{ $item->id }})"
                                                            class="btn btn-warning btn-sm">
                                                        <i class="fa fa-recycle"></i>
                                                        Update Status
                                                    </button>
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

    <div class="modal fade" id="ChangeStatus" tabindex="-1" role="dialog" aria-labelledby="RefundModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 768px">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>
                        Change Status
                    </h3>
                    <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"></i>

                </div>
                <div class="modal-body p-5 row" id="modal_Body">
                    <label for="newStatus" class="mb-2 p-0">
                        Select New Status
                    </label>
                    <select onchange="newStatusChange(this)" id="newStatus" class="form-control">
                        <option value="0">select new status</option>
                        @foreach($status as $item)
                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                    <div id="show_create_new_wallet_alert" class="alert alert-danger text-center mt-3">
                        <input type="checkbox" value="1" name="create_wallet">
                        Create New Record for Wallet
                    </div>
                </div>

                <input type="hidden" name="refund_id" id="refund_id">
                <div class="modal-footer">
                    <button data-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                    <button onclick="UpdateRefundStatus()" type="button" class="btn btn-success">Update</button>
                </div>
            </div>
        </div>
    </div>
    @include('admin.sections.remove_modal')
@endsection
@push('style')

@endpush
@push('script')
    <script>
        function update_status(id) {
            $('#show_create_new_wallet_alert').addClass('d-none');
            $('#ChangeStatus').modal('show');
            $('#refund_id').val(id);
        }

        function UpdateRefundStatus() {
            let id = $('#refund_id').val();
            let newStatus = $('#newStatus').val();
            let create_wallet = $('input[name="create_wallet"]:checked').val();
            if (create_wallet == undefined) {
                create_wallet = 0;
            }
            if (newStatus == 0) {
                alert('please select a new status');
                return;
            }
            let url = "{{ route('admin.UpdateRefundStatus') }}";
            $.ajax({
                url: url,
                dataType: 'json',
                method: 'POST',
                data: {
                    id: id,
                    newStatus: newStatus,
                    create_wallet: create_wallet,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response[0] == 1) {
                        window.location.reload();
                    }else {
                        $('#ChangeStatus').modal('hide');
                        alert('something went wrong');
                        setTimeout(function (){
                            window.location.reload();
                        },2000);
                    }
                }
            });

        }

        function newStatusChange(tag) {
            $('#show_create_new_wallet_alert').addClass('d-none');
            let value = $(tag).val();
            if (value == 3) {
                $('#show_create_new_wallet_alert').removeClass('d-none');
            }
            if (newStatus == 0) {
                alert('please select a new status');
                return;
            }
        }

        function changeUserWallet(user_id, type) {
            let amount = $('#wallet').val();
            let wallet_description = $('#wallet_description').val();
            if (amount < 10) {
                alert('minimum amount is 10$');
                return false;
            }
            if (wallet_description.length == 0) {
                alert('wallet description is required');
                return false;
            }
            $.ajax({
                url: "{{ route('admin.user.wallet.change') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: user_id,
                    type: type,
                    amount: amount,
                    description: wallet_description,
                },
                dataType: 'json',
                method: 'post',
                success: function (response) {
                    if (response[0] === 1) {
                        window.location.reload();
                    }
                },

            })
        }
    </script>
@endpush
