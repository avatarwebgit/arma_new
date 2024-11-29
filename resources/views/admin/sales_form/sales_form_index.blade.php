@extends('admin.layouts.main')
@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
{{--            <h4 class="m-b-10"> {{ __('Inquiries') }}</h4>--}}
        </div>
        <ul class="breadcrumb mt-3">
            <li class="breadcrumb-item active"></li>

            <li class="breadcrumb-item active"></li>
        </ul>
    </div>
@endsection

@section('title')
    Sales Form
@endsection

@section('content')
    @include('admin.sales_form.change_status_modal')
    @include('admin.sales_form.show_reason_modal')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <h5 class="text-white mb-2">
                            Sales Form
                        </h5>
                    </div>
                    <div class="col-md-12">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-dark mb-2">
                            Back
                        </a>
                        <div class="markets-pair-list table-responsive-sm">

                            <div id="alert"></div>
                            <table class="table table-striped">
                                <thead>
                                <tr class="text-center">
                                    <th>Row</th>
                                    <th>Date</th>
                                    {{--    <th>Time</th>--}}
                                    <th>Commodity</th>
                                    <th>User ID</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($forms as $key=>$form)
                                    <tr class="text-center">
                                        <td>
                                            {{ $forms->firstItem()+$key }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($form->crated_at)->format('m/d/Y') }}
                                        </td>
                                        {{--        <td>--}}
                                        {{--            {{ \Carbon\Carbon::parse($form->crated_at)->format('H:m') }}--}}
                                        {{--        </td>--}}
                                        <td>
                                            {{ $form->commodity }}
                                            {{--            On--}}
                                        </td>
                                        <td>
                                            {{ $form->User->user_id }}
                                        </td>
                                        <td>
                                            {{ $form->User->email }}
                                        </td>
                                        <td>
                                            {{ $type }}
                                        </td>

                                        <td class="text-right">
                                            <button onclick="copy_sales_form({{ $form->id }})"
                                                    class="btn btn-sm btn-primary text-white mr-1">
                                                Copy
                                            </button>

                                                                                                <a href="{{ route('sale_form',['page_type'=>'Edit','item'=>$form->id]) }}"
                                                                                                   class="btn btn-sm btn-info text-white mr-1">
                                                                                                    <i class="fa fa-pen"></i>
                                                                                                </a>
{{--                                            <a href="{{ route('sale_form.show',['id'=>$form->id]) }}"--}}
{{--                                               class="btn btn-sm btn-primary text-white mr-1">--}}
{{--                                                <i class="fa fa-eye"></i>--}}
{{--                                            </a>--}}
{{--                                            <button onclick="show_change_status_modal({{ $form->id }})"--}}
{{--                                                    class="btn btn-sm btn-warning text-white mr-1">--}}
{{--                                                change status--}}
{{--                                            </button>--}}

                                            <a onclick="removeModal({{ $form->id }},event)"
                                               class="btn btn-sm btn-danger text-white mr-1">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>


                            </table>
                            <div class="text-center">
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $forms->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.sections.remove_modal')
@endsection
@push('style')
    <style>
        .change_status_btn {
            border: 1px solid #ccc;
            width: fit-content;
            padding: 2px 10px;
            margin-right: 10px;
            color: black;
        }

        button.active {
            background-color: #001062;
            color: white;
        }

        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 50% !important;
                margin: 1.75rem auto !important;
            }
        }
    </style>
@endpush
@push('script')
    <script>
        function removeModal(id, e) {
            e.stopPropagation();
            let remove_modal = $('#remove_modal');
            $('#id').val(id);
            remove_modal.modal('show');
        }

        function Remove() {
            let id = $('#id').val();
            $.ajax({
                url: "{{ route('admin.sales_form.remove') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                dataType: "json",
                method: "post",
                beforeSend: function () {

                },
                success: function (msg) {
                    if (msg) {
                        $('#remove_modal').modal('hide');
                        if (msg[0] == 1) {
                            window.location.reload();
                        } else {
                            $('#alert').html(msg[1]);
                        }
                    }
                }
            })
        }

        function copy_sales_form(form_id) {
            $.ajax({
                url: "{{ route('admin.sales_form.copy') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    form_id: form_id,
                },
                dataType: "json",
                method: "post",
                beforeSend: function () {

                },
                success: function (msg) {
                    if (msg) {
                        if (msg[0] == 1) {
                            window.location.reload();
                        } else {
                            $('#alert').html(msg[1]);
                        }
                    }
                }
            })
        }

        function EditCurrency(id, deposit_value, cash_pending_currency) {
            $('#Edit_Currency').modal('show');
            $('#currency_cash_pending').val(cash_pending_currency);
            $('#amount_cash_pending').val(deposit_value);
            $('#id_cash_pending').val(id);
        }

        function UpdateCashPending() {
            $('#currency_cash_pending_error').addClass('d-none');
            let url = "{{ route('sale_form.UpdateCashPending') }}";
            let id = $('#id_cash_pending').val();
            let amount = $('#amount_cash_pending').val();
            let currency = $('#currency_cash_pending').val();
            if (currency.length == 0) {
                $('#currency_cash_pending_error').text('Please enter a currency');
                $('#currency_cash_pending_error').removeClass('d-none');
                return;
            }
            $.ajax({
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    amount: amount,
                    currency: currency,
                },
                dataType: "json",
                method: "post",
                beforeSend: function () {
                    // $('.save_btn').prop('disabled', true);
                },
                success: function (data) {
                    if (data[0] == 1) {
                        window.location.reload();
                    }
                }
            })
        }

        function show_change_status_modal(form_id, status = null) {
            $('#status_id').val(null);
            $('#approved_box').find('input').prop('checked', false);
            $('.status_options').addClass('d-none');
            $('.change_status_btn ').removeClass('active');
            $('#modal_form_id').val(form_id);
            $('#form_change_status').val(status);
            $('.change_status_btn').removeClass('d-none');
            if (status == 6) {
                $('#pending_button').addClass('d-none');
            }
            if (status == 4) {
                $('#Reject-status-btn').addClass('d-none');
            }

            if (status == 3) {
                $('#pending_button').addClass('d-none');
            }


            let change_status_modal = $('#change_status_modal');
            $(change_status_modal).modal('show');
        }

        function changeDeposit(tag) {
            $('#deposit_input').addClass('d-none');
            let value = $(tag).val();
            if (value == 1) {
                $('#deposit_input').removeClass('d-none')
            }
        }

        function SaveChangeStatus() {
            $('#message_error').addClass('d-none');
            $('#amount_error').addClass('d-none');
            $('#currency_error').addClass('d-none');
            $('#deposit_error').addClass('d-none');

            let has_deposit = null;
            let deposit_value = null;
            let message = null;
            let currency = null;

            let change_status_modal = $('#change_status_modal');
            $(change_status_modal).modal('show');
            let form_id = $('#modal_form_id').val();
            let status_id = $('#status_id').val();
            let form_change_status = $('#form_change_status').val();

            if (status_id.length == 0) {
                alert('Please select a new status');
                return;
            }
            //status_id == 4 Reject
            //status_id == 5 Approved
            if (status_id == 5) {
                has_deposit = $('input[name="deposit"]:checked').val();
                if (form_change_status == 6) {
                    has_deposit = 0;
                } else {
                    if (has_deposit) {
                        if (has_deposit == 1) {
                            deposit_value = $('#deposit').val();
                            currency = $('#currency').val();
                            if (deposit_value.length == 0) {
                                $('#amount_error').text('please determine Amount');
                                $('#amount_error').removeClass('d-none');
                                return;
                            }
                            if (currency.length == 0) {
                                $('#currency_error').text('please determine currency');
                                $('#currency_error').removeClass('d-none');
                                return;
                            }
                        }
                    } else {
                        $('#deposit_error').text('please determine deposit');
                        $('#deposit_error').removeClass('d-none');
                        return;
                    }
                }

            }
            //status_id =3 Data Pending
            if (status_id == 3 || status_id == 4) {
                message = $('#message').val();
                if (message.length === 0) {
                    $('#message_error').text('please determine Message');
                    $('#message_error').removeClass('d-none');
                    return;
                }
            }
            let url = "{{ route('sale_form.change_status') }}";
            $.ajax({
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    form_id: form_id,
                    status_id: status_id,
                    has_deposit: has_deposit,
                    deposit_value: deposit_value,
                    currency: currency,
                    message: message,
                },
                dataType: "json",
                method: "post",
                beforeSend: function () {
                    // $('.save_btn').prop('disabled', true);
                },
                success: function (data) {
                    if (data[0] == 1) {
                        $('.change_status_btn').prop('disabled', false);
                        $(change_status_modal).modal('hide');
                        window.location.href=data[2];
                    }
                }
            })
        }

        $('.change_status_btn').click(function () {
            $('#message_error').addClass('d-none');
            $('#approved_box').find('input').prop('checked', false);
            $('.status_options').addClass('d-none');
            $('.change_status_btn').removeClass('active');
            $(this).addClass('active');
            let status_id = $(this).attr('data-id');
            $('#status_id').val(status_id);
            if (status_id == 4) {
                //Reject
                $('#message_box').removeClass('d-none');
            }
            if (status_id == 5) {
                //Approved
                $('#approved_box').removeClass('d-none');
            }
            if (status_id == 3) {
                //Data Pending
                $('#message_box').removeClass('d-none');
            }
            let form_change_status = $('#form_change_status').val();
            if (form_change_status == 6) {
                $('#approved_box').addClass('d-none')
            }
        });

        function ShowRejectReason(message) {
            $('#reason_status_modal').modal('show');
            $('#reason_message').text(message);
        }

    </script>
@endpush
