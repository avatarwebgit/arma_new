@extends('admin.layouts.main')

@section('title')
    @if($type==0)
        @php
            $user_status='Index';
        @endphp
    @elseif($type==1)
        @php
            $user_status='Registering';
        @endphp
    @elseif($type==3)
        @php
            $user_status='Confirmed';
        @endphp
    @elseif($type==2)
        @php
            $user_status='Rejected';
        @endphp
    @elseif($type=='seller')
        @php
            $user_status='Seller';
        @endphp

    @elseif($type=='buyer')
        @php
            $user_status='Buyer';
        @endphp
    @endif

    {{ $user_status }} Users
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ $user_status }} {{ __('Users') }}</h4>
        </div>
        <ul class="breadcrumb mt-3">
            <li class="breadcrumb-item active">{{ __('Users') }}</li>
            <li class="breadcrumb-item active">{{ $user_status }} {{ __('Users') }}</li>
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
                            <div class="col-12">
                                <h5 class="text-white mb-2">
                                    {{ $type }} users({{ count($users) }})
                                </h5>
                            </div>
                            <div class="col-md-12">
                                <div class="markets-pair-list">
                                    <div id="alert"></div>
                                    @if($type==0)
                                        @include('admin.users.index')
                                    @elseif($type==1)
                                        @include('admin.users.registering_user')
                                    @elseif($type==2)
                                        @include('admin.users.confirmed_users')
                                    @elseif($type==3)
                                        @include('admin.users.rejected_user')
                                    @elseif($type=='seller')
                                        @include('admin.users.seller')
                                    @elseif($type=='buyer')
                                        @include('admin.users.buyer')
                                    @endif
                                    <div class="text-center">
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $users->links() }}
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
    @include('admin.sections.ShowPreviewSections')
    @include('admin.sections.RejectedUser')
    @include('admin.sections.create_account_modal')
@endsection
@push('style')

@endpush
@push('script')
    <script>
        function showUserPreview(user_id) {
            let UserPreview = $('#UserPreview');
            UserPreview.modal('show');

            let url = "{{ route('admin.get_user_information') }}"
            $.ajax({
                url: url,
                dataType: 'json',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: user_id
                },
                success: function (msg) {
                    if (msg[0] == 1) {
                        $('#UserPreview_modal_body').html(msg[1])
                    }
                }
            })

        }

        function ChangeStatus(user_id, new_status) {
            let url = "{{ route('admin.change_status') }}"
            $.ajax({
                url: url,
                dataType: 'json',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: user_id,
                    new_status: new_status
                },
                success: function (msg) {
                    if (msg[0] == 1) {
                        window.location.reload();
                    }
                }
            })

        }

        function RejectedUser(user_id, reason = null) {
            let RejectedModal = $('#RejectedModal');
            RejectedModal.modal('show');
            console.log(reason);
            if (reason == null) {
                $('#user_id').val(user_id);
                $('#Reject_reason_error').addClass('d-none');
                $('#reject_user_question').removeClass('d-none');
                $('#reject_user_question_button').removeClass('d-none');
                $('#Reject_reason').attr('disabled', false);
            } else {
                $('#Reject_reason').val(reason);
                $('#Reject_reason').attr('disabled', true);
                $('#reject_user_question').addClass('d-none');
                $('#reject_user_question_button').addClass('d-none');
            }
        }

        function SendRejectReason() {
            $('#Reject_reason_error').addClass('d-none');
            $('#is_reject_error').addClass('d-none');
            let user_id = $('#user_id').val();
            let reason = $('#Reject_reason').val();
            let is_reject = $('input[name="is_reject"]:checked').val();

            if (is_reject != 1) {
                $('#is_reject_error').removeClass('d-none');
                return;
            }
            if (reason.length < 20) {
                $('#Reject_reason_error').removeClass('d-none');
                return;
            }
            console.log('okkk');

            let url = "{{ route('admin.change_status') }}"
            $.ajax({
                url: url,
                dataType: 'json',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: user_id,
                    reason: reason,
                    is_reject: is_reject,
                    new_status: 3,
                },
                success: function (msg) {
                    if (msg[0] == 1) {
                        window.location.reload();
                    }
                }
            })
        }

        function removeModal(id, e) {
            e.stopPropagation();
            let remove_modal = $('#remove_modal');
            $('#id').val(id);
            remove_modal.modal('show');
        }

        function Remove() {
            let id = $('#id').val();
            $.ajax({
                url: "{{ route('admin.user.remove') }}",
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

        function ChangeRegisterStatus(tag, user_id) {
            let status = $(tag).val();
            if (status != 2) {
                return;
            }
            let new_status = 2;
            ChangeStatus(user_id, new_status);
        }

        function showCreateAccountModal(user_id, email, user_type) {
            if (user_type == 1) {
                //seller
                $('#Admin').prop('checked', true);
            }
            if (user_type == 2) {
                //seller
                $('#Seller').prop('checked', true);
            }
            if (user_type == 3) {
                //seller
                $('#Buyer').prop('checked', true);
            }
            $('#create_account_modal').modal('show');
            $('#new_password').val('');
            $('#new_password_copied').addClass('d-none');
            $('#user_id').val(user_id);
            $('#user_name').text(email);
            $('#user_type').val(user_type);
        }

        function randString() {
            var dataSet = $('#new_password').attr('data-character-set').split(',');
            var possible = '';
            if ($.inArray('a-z', dataSet) >= 0) {
                possible += 'abcdefghijklmnopqrstuvwxyz';
            }
            if ($.inArray('A-Z', dataSet) >= 0) {
                possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            }
            if ($.inArray('0-9', dataSet) >= 0) {
                possible += '0123456789';
            }
            if ($.inArray('#', dataSet) >= 0) {
                possible += '![]{}()%&*$#^<>~@|';
            }

            var text = '';
            for (var i = 0; i < 20; i++) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            $('#new_password').val(text);
        }

        function CopyUserName() {
            let password = $('#new_password').val();
            let user_type = $('#user_type').val();
            let user_id = $('#user_id').val();
            if (password.length == 0) {
                alert('Please enter Password');
                return;
            }
            $('#new_password').select();
            document.execCommand('copy');
            $('#new_password_copied').removeClass('d-none');
            setTimeout(function () {
                save_role(user_id, password, user_type);
            }, 2000);
        }

        function save_role(user_id, password, user_type) {
            $.ajax({
                url: '{{ route('admin.user.update_role') }}',
                dataType: 'json',
                method: 'POST',
                data: {
                    user_id: user_id,
                    password: password,
                    role: user_type,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    window.location.reload();
                },
            })
        }
    </script>
@endpush
