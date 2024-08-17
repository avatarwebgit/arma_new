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
        <div style="max-width: 900px" class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>
                        Add User
                    </h3>
                    <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"></i>
                </div>
                <div class="modal-body p-5 row text-center">
                    <div class="row">

                        <div class="col-12 col-md-3">
                            <div class="text-left">
                                <label for="user_type" class="mb-2">User Type *</label>
                                <select class="form-control" id="user_type" data-live-search="true">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="text-left">
                                <label for="user_name" class="mb-2">Name</label>
                                <input class="form-control" id="user_name">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="text-left">
                                <label for="user_email" class="mb-2">Email</label>
                                <input class="form-control" id="user_email">
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <div class="text-left">
                                <label for="user_company" class="mb-2">Company</label>
                                <input class="form-control" id="user_company">
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-3 mb-5">
                        <button class="btn btn-sm btn-info" onclick="SearchUser()">
                            Search
                        </button>
                        {{--                        <button class="btn btn-sm btn-danger me-2" data-dismiss="modal" aria-label="Close">Close--}}
                        {{--                        </button>--}}
                    </div>

                    <ul id="userList" class="list-group"></ul>

                    <div id="noResults" class="no-results" style="display:none;">کاربری پیدا نشد!</div>
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

        .user-list .list-group-item {

            display: flex;

            justify-content: space-between;

            align-items: center;

        }

        .user-actions button {

            margin-left: 10px;

        }

        .no-results {

            text-align: center;

            color: #dc3545;

            padding: 20px;

        }

    </style>
@endpush
@push('script')
    <script>
        function SearchUser() {
            // گرفتن مقادیر از فرم
            var userType = $('#user_type').val();
            var userName = $('#user_name').val();
            var userEmail = $('#user_email').val();
            var userCompany = $('#user_company').val();

            // بررسی کنید که userType انتخاب شده
            if (!userType) {
                alert('User Type is required!'); // پیغام خطا در صورت عدم انتخاب
                return;
            }

            $('#userList').empty();
            $('#noResults').hide(); // مخفی کردن پیام عدم نتیجه

            // انجام درخواست AJAX
            $.ajax({
                type: 'POST',
                url: "{{ route('sale_form.user_permission.search') }}", // آدرس نقطه پایانی که اطلاعات را در سمت سرور پردازش می‌کند
                data: {
                    user_type: userType,
                    user_name: userName,
                    user_email: userEmail,
                    user_company: userCompany,
                    _token: "{{ csrf_token() }}" // اضافه کردن توکن CSRF
                },
                success: function (response) {
                    if (response.success) {
                        if (response.data.length === 0) {
                            $('#noResults').show();
                        } else {
                            response.data.forEach(function (user) {
                                $('#userList').append(`
                                <li class="list-group-item">
                                    <div class="text-left">
                                        <input type="checkbox" value="${user.id}" class="user-checkbox ms-3">User ID: ${user.user_id} / Name: ${user.full_name} / Email: ${user.email} / Company: ${user.company_name}
                                    </div>
                                </li>
                            `);
                            });

                            // اضافه کردن دکمه جمع‌آوری ID ها پس از لیست کاربر
                            $('#userList').append(`
                            <button style="max-width: 150px" id="collectIdsButton" class="btn btn-success btn-sm mt-2">
                                Add Users
                            </button>
                        `);
                        }
                    } else {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    alert('An error occurred while processing your request.');
                }
            });
        }

        // جمع‌آوری ID کاربران انتخاب شده
        $(document).on('click', '#collectIdsButton', function () {
            const selectedIds = $('.user-checkbox:checked').map(function () {
                return this.value;
            }).get();

            let market_id = "{{ $market_id }}"; // شناسه بازار را از PHP گرفته‌ایم

            if (selectedIds.length > 0) {
                // ارسال داده‌ها به سرور
                $.ajax({
                    url: "{{ route('sale_form.store_ids') }}", // آدرس سرور
                    type: 'POST', // نوع درخواست
                    data: {
                        ids: selectedIds,
                        market_id: market_id,
                        _token: "{{ csrf_token() }}"
                    }, // داده‌ها را به فرمتی مناسب ارسال می‌کنیم
                    success: function (response) {
                        // واکنش موفقیت‌آمیز
                        window.location.reload();
                    },
                    error: function (xhr, status, error) {
                        // واکنش خطا
                        alert('Error sending IDs to the server: ' + error);
                    }
                });
            } else {
                alert('At least one user must be selected');
            }
        });

        function rolePermission(market_id) {
            let checkbox = $('.checkbox');
            let role_ids = [];

            $.each(checkbox, function (index, val) {
                if ($(val)[0].checked) {
                    role_ids.push($(val).data('id'));
                }
            });

            let url = "{{ route('sale_form.store_roles') }}";
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
                        alert('something went wrong');
                    }
                }
            });
        }

        function SaveUserMarketPermission(market_id) {
            $('#user_error').addClass('d-none');
            let user_id = $('#search_user').val();

            if (user_id.length == 0) {
                $('#user_error').removeClass('d-none');
                return false;
            }

            let url = "{{ route('sale_form.store_ids') }}";
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
                        alert('something went wrong');
                    }
                }
            });
        }

        function ShowAddModal() {
            $('#user_error').addClass('d-none');
            $('#ShowAddModal').modal('show');
        }

        $('select').selectpicker({
            'title': 'Select'
        });
    </script>
@endpush

