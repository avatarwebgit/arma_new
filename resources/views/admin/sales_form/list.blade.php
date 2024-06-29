@extends('admin.layouts.main')

@section('title')
    Sales Form
@endsection

@section('content')
    @include('admin.sales_form.change_status_modal')
    <div class="row">
        <div class="col-12">
            <div>
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12">
                                <h5 class="text-white mb-2">
                                    Sales Form
                                </h5>
                            </div>
                            <div class="col-md-12">
                                <div class="markets-pair-list table-responsive-sm">
                                    <div id="alert"></div>
                                    <table class="table table-striped">
                                        {{--                                        //index--}}
                                        @if($status==1)
                                            @include('admin.sales_form.index_list')
                                        @endif
                                        {{--                                        //cash pending--}}
                                        @if($status==2)
                                            @include('admin.sales_form.cash_pending_list')
                                        @endif
                                        {{--                                        //data pending--}}
                                        @if($status==3)
                                            @include('admin.sales_form.data_pending_list')
                                        @endif
                                        {{--                                        //reject--}}
                                        @if($status==4)
                                            @include('admin.sales_form.reject_list')
                                        @endif
                                        {{--                                        //approved--}}
                                        @if($status==5)
                                            @include('admin.sales_form.approved_list')
                                        @endif
                                        {{--                                        //approved--}}
                                        @if($status==6)
                                            @include('admin.sales_form.preparation_list')
                                        @endif

                                    </table>
                                    <div class="text-center">
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $items->links() }}
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

        function EditCurrency(id, deposit_value, cash_pending_currency) {
            $('#Edit_Currency').modal('show');
            $('#currency_cash_pending').val(cash_pending_currency);
            $('#amount_cash_pending').val(deposit_value);
            $('#id_cash_pending').val(id);
        }

        function UpdateCashPending() {
            let url = "{{ route('sale_form.UpdateCashPending') }}";
            let id = $('#id_cash_pending').val();
            let amount = $('#amount_cash_pending').val();
            let currency = $('#currency_cash_pending').val();
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
                }else{
                    if (has_deposit) {
                        if (has_deposit == 1) {
                            deposit_value = $('#deposit').val();
                            currency = $('#currency').val();
                            if (deposit_value.length == 0) {
                                alert('please determine Amount');
                                return;
                            }
                            if (currency.length == 0) {
                                alert('please determine currency');
                                return;
                            }
                        }
                    } else {
                        alert('please determine deposit');
                        return;
                    }
                }

            }
            //status_id =3 Data Pending
            if (status_id == 3 || status_id == 4) {
                message = $('#message').val();
                if (message.length === 0) {
                    alert('please determine Message');
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
                        window.location.reload();
                    }
                }
            })
        }

        $('.change_status_btn').click(function () {
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

    </script>
@endpush
