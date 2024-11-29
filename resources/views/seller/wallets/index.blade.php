@extends('seller.layouts.main')
@section('title')
    Wallet
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('home/css/profile_panel.css') }}">

    <style>
        .position-relative {
            position: relative;
        }

        #close_alert {
            position: absolute;
            cursor: pointer;
            top: 5px;
            left: 5px;
        }

        .my-2 {
            margin: 2rem 0;
        }

        .ht-btn {
            border: none !important;
            color: white !important;
        }

        .ht-btn:hover {
            background-color: #E8D2A6 !important;
            color: #000 !important;
        }

        .single-input-item > label, .single-input-item > input {
            font-size: 14px !important;
        }
    </style>
@endsection

@section('script')
    <script>
        function Refund(user_id, wallet) {
            $('.modal-footer').removeClass('d-none');
            let message = '$' + wallet + '  Refund To Your Account<br />Are You sure ?';
            $('#modal_Body').html(message);
            $('#amount_refund').text(wallet);
            $('#RefundModal').modal('show');
            $('#user_id').val(user_id);
            $('#amount').val(wallet);
        }

        function RefundRequest() {
            let user_id = $('#user_id').val();
            let amount = $('#amount').val();
            let url = "{{ route('refund') }}"
            $.ajax({
                url: url,
                dataType: 'json',
                method: 'POST',
                data: {
                    user_id: user_id,
                    amount: amount,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    let message;
                    if (data[0] == 0) {
                        message = '<div class="alert alert-danger text-center">' +
                            'Something Went Wrong</div>';
                    } else {
                        message = '<div class="alert alert-success text-center">Refund Request Successfully Was Sent</div>';
                    }

                    $('#modal_Body').html(message);
                    $('.modal-footer').addClass('d-none');
                    setTimeout(function () {
                        $('#RefundModal').modal('hide');
                    }, 3000);
                }
            })
        }

        function changeUserWallet(user_id) {
            let url = "{{ route('payment.paypal') }}";
            let redirect_route = "{{ route('seller.wallet') }}"
            let price = $('#wallet').val();
            let wallet_description = $('#wallet_description').val();
            if (price < 1) {
                alert('minimum amount is 1 $');
                return false;
            }
            if (wallet_description.length == 0) {
                alert('description is required');
                return false;
            }

            $.ajax({
                url: url,
                data: {
                    user_id: user_id,
                    price: price,
                    description: wallet_description,
                    redirect_route: redirect_route,
                    _token: "{{ csrf_token() }}",
                },
                method: 'post',
                success: function (data) {
                    if (data[0] == 1) {
                        window.location.href = data[1];
                    }
                }

            })
        }
    </script>
@endsection
@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-12 mb-3">
                                        <h5>
                                            <span>wallet: </span>
                                            <span>{{ number_format($wallet).'$' }}</span>
                                        </h5>
                                        <div>
                                            <label for="wallet">
                                                amount ($)
                                                <input id="wallet" class="form-control" name="wallet" value="0">
                                            </label>

                                        </div>

                                        <div class="mt-3">
                                            <label for="wallet_description">Description *</label>
                                            <textarea id="wallet_description" class="form-control form-control-sm"
                                                      name="wallet_description"></textarea>
                                        </div>
                                        <div class="mt-3">
                                            <button type="button" onclick="changeUserWallet({{ $user->id }},1)"
                                                    class="btn btn-success">
                                                PayPal
                                            </button>
                                            @if($wallet>0)
                                                <button type="button"
                                                        onclick="Refund({{ $user->id }},'{{ $wallet }}')"
                                                        class="btn btn-warning">
                                                    Refund
                                                </button>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="markets-pair-list">
                                            <div id="alert"></div>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>amount</th>
                                                    <th>status</th>
                                                    <th>type</th>
                                                    <th>description</th>
                                                    <th>created at</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($transactions as $key=>$item)
                                                    <tr>
                                                        <td>
                                                            {{ $key }}
                                                        </td>
                                                        <td>
                                                            {{ number_format($item->amount).' $' }}
                                                        </td>
                                                        <td>
                                                            @if($item->status==0)
                                                                <span class="text-danger">
                                                            <i class="fa fa-times-circle"></i>
                                                        </span>
                                                            @else
                                                                <span class="text-success">
                                                             <i class="fa fa-check"></i>
                                                        </span>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            @if($item->type==0)
                                                                <span class="text-danger">
                                                            <i class="fa fa-arrow-down"></i>
                                                        </span>

                                                            @else
                                                                <span class="text-success">
                                                        <i class="fa fa-arrow-up"></i>
                                                        </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $item->description }}
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
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
    </div>

    <div class="modal fade" id="RefundModal" tabindex="-1" role="dialog" aria-labelledby="RefundModal"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 768px">
            <div class="modal-content">
                <div class="modal-header">

                    <h3>
                        Refund Request
                    </h3>
                    <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"></i>

                </div>
                <div class="modal-body p-5 row" id="modal_Body">
                    Refund To Your Account
                    <br>
                    Are you sure ?
                </div>
                <input type="hidden" name="user_id" id="user_id">
                <input type="hidden" name="amount" id="amount">
                <div class="modal-footer">
                    <button data-dismiss="modal" type="button" class="btn btn-danger">Cancel</button>
                    <button onclick="RefundRequest()" type="button" class="btn btn-success">Refund</button>
                </div>
            </div>
        </div>
    </div>
@endsection

