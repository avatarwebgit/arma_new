@extends('admin.layouts.main')

@section('title')
    Contact Message
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
                                    Contact Message
                                </h5>
                            </div>
                            <div class="col-md-12">
                                <div class="markets-pair-list">
                                    <div id="alert"></div>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>email</th>
                                            <th>type</th>

                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($contacts as $key=>$contact)
                                            <tr>
                                                <td>
                                                    {{ $contacts->firstItem()+$key }}
                                                </td>
                                                <td>
                                                    {{ $contact->email }}
                                                </td>
                                                <td>
                                                    {{ $contact->type }}
                                                </td>

                                                <td>

                                                    <a href="{{ route('admin.contact.show',['contact'=>$contact->id]) }}"
                                                       class="btn btn-sm btn-primary text-white mr-1">
                                                        <i class="fa fa-eye"></i>
                                                    </a>


                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $contacts->links() }}
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

        function show_change_status_modal(form_id) {
            $('#status_id').val(null);
            $('#approved_box').find('input').prop('checked', false);
            $('.status_options').addClass('d-none');
            $('.change_status_btn ').removeClass('active');
            $('#modal_form_id').val(form_id);
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
            let data_pending_message = null;

            let change_status_modal = $('#change_status_modal');
            $(change_status_modal).modal('show');
            let form_id = $('#modal_form_id').val();
            let status_id = $('#status_id').val();
            if (status_id.length == 0) {
                alert('Please select a new status');
                return;
            }
            //status_id == 4 Reject
            //status_id == 5 Approved
            if (status_id == 5) {
                has_deposit = $('input[name="deposit"]:checked').val();
                if (has_deposit) {
                    if (has_deposit == 1) {
                        deposit_value = $('#deposit').val();
                        if (deposit_value.length == 0) {
                            alert('please determine deposit');
                            return;
                        }
                    }
                } else {
                    alert('please determine deposit');
                    return;
                }
            }
            //status_id =3 Data Pending
            if (status_id == 3) {
                data_pending_message = $('#data_pending_message').val();
                if (data_pending_message.length === 0) {
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
                    data_pending_message: data_pending_message,
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
            }
            if (status_id == 5) {
                //Approved
                $('#approved_box').removeClass('d-none');
            }
            if (status_id == 3) {
                //Data Pending
                $('#data_pending').removeClass('d-none');
            }
        });

    </script>
@endpush