@extends('home.homelayout.app')
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
            let message = '$'+wallet + '  Refund To Your Account<br />Are You sure ?';
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
                        message ='<div class="alert alert-danger text-center">' +
                            'Something Went Wrong</div>';
                    }else {
                        message ='<div class="alert alert-success text-center">Refund Request Successfully Was Sent</div>';
                    }

                    $('#modal_Body').html(message);
                    $('.modal-footer').addClass('d-none');
                    setTimeout(function(){
                        $('#RefundModal').modal('hide');
                    }, 3000);
                }
            })
        }
        function changeUserWallet(user_id) {
            let url = "{{ route('payment.paypal') }}";
            let redirect_route = "{{ route('bidder.wallet') }}"
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
                <div class="col-12 col-lg-3">
                    @include('bidder.sidebar')
                </div>
                <div class="col-12 col-lg-9">
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
                                                    <th>amount($)</th>
                                                    <th>status</th>
                                                    <th>Update</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($items as $key=>$item)
                                                    <tr>
                                                        <td>
                                                            {{ $key }}
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


@endsection

