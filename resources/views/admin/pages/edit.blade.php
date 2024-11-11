@extends('admin.layouts.main')

@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div id="settings-profile"
                             aria-labelledby="settings-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div>

                                        <a href="{{ route('admin.pages.index') }}"
                                           class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                        @if($page->id==20)
                                            <button onclick="AddressModal()"
                                                    class="btn btn-success btn-sm mb-2">
                                                <i class="icon ion-md-arrow-back mr-1"></i>
                                                <span>
                                                Add New Address
                                            </span>
                                            </button>
                                            <button onclick="AddressHelp()"
                                                    class="btn btn-primary btn-sm mb-2">
                                                <i class="icon ion-md-arrow-back mr-1"></i>
                                                <span>
                                                Add Help & Support
                                            </span>
                                            </button>
                                        @endif
                                    </div>
                                    @if($page->id==20 and count($contact_addresses)>0)
                                        <div id="addresses_section">
                                            <h2>
                                                Addresses
                                            </h2>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Tel 1</th>
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($contact_addresses as $key=>$item)
                                                    <tr id="address_modal_{{ $item->id }}"
                                                        data-title="{{ $item->title_modal }}"
                                                        data-tel-1="{{ $item->tel_1_modal }}"
                                                        data-tel-2="{{ $item->tel_2_modal }}"
                                                        data-tel-3="{{ $item->tel_3_modal }}"
                                                        data-email="{{ $item->email_modal }}"
                                                        data-email-2="{{ $item->email_2_modal }}"
                                                        data-address="{{ $item->address_modal }}"
                                                    >
                                                        <td>
                                                            {{ $key+1 }}
                                                        </td>
                                                        <td>
                                                            {{ $item->title_modal }}
                                                        </td>

                                                        <td>
                                                            {{ $item->tel_1_modal }}
                                                        </td>
                                                        <td>
                                                            {{ $item->email_modal }}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <button onclick="AddressModal({{ $item->id }})"
                                                                        class="btn btn-info btn-sm mb-2 mr-2">
                                                                    <i class="fa fa-pen mr-1"></i>
                                                                </button>
                                                                <button onclick="removeModal({{ $item->id }})"
                                                                        class="btn btn-danger btn-sm mb-2">
                                                                    <i class="fa fa-trash mr-1"></i>
                                                                </button>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    @if($page->id==20 and count($contact_helps)>0)
                                        <div id="help_section">
                                            <h2>
                                                Help & Support
                                            </h2>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Link</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($contact_helps as $key=>$item)
                                                    <tr id="help_modal_{{ $item->id }}"
                                                        data-title="{{ $item->title_help_modal }}"
                                                        data-description="{{ $item->description_help_modal }}"
                                                        data-link="{{ $item->link_help_modal }}"
                                                    >
                                                        <td>
                                                            {{ $key+1 }}
                                                        </td>
                                                        <td>
                                                            {{ $item->title_help_modal }}
                                                        </td>

                                                        <td>
                                                            {{ substr($item->description_help_modal,0,50).'...' }}
                                                        </td>
                                                        <td>
                                                            {{ $item->link_help_modal }}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <button onclick="AddressHelp({{ $item->id }})"
                                                                        class="btn btn-info btn-sm mb-2 mr-2">
                                                                    <i class="fa fa-pen mr-1"></i>
                                                                </button>
                                                                <button onclick="removeHelpModal({{ $item->id }})"
                                                                        class="btn btn-danger btn-sm mb-2">
                                                                    <i class="fa fa-trash mr-1"></i>
                                                                </button>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    <div class="settings-profile">
                                        <div class="col-12 mb20">
                                            <div class="text-center position-relative">
                                                <img class="small-image" alt="banner"
                                                     src="{{ imageExist(env('UPLOAD_BANNER_PAGE'),$page->banner) }}">
                                            </div>
                                            <hr>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data"
                                              action="{{ route('admin.page.update',['page'=>$page->id]) }}">
                                            @method('put')
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="title">Title</label>
                                                    <input id="title" name="title" class="form-control"
                                                           value="{{ $page->title }}">
                                                    @error('title')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>

                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="menu">Menu</label>
                                                    <select id="menu" name="menu" class="form-control">
                                                        <option value="">Select Menu</option>
                                                        @foreach($menus as $menu)
                                                            <option
                                                                {{ in_array($menu->id,$page->Menus()->pluck('id')->toArray()) ? 'selected' : '' }} value="{{ $menu->id }}">{{ $menu->title }}</option>
                                                            @foreach($menu->children as $child)
                                                                <option
                                                                    {{ in_array($child->id,$page->Menus()->pluck('id')->toArray()) ? 'selected' : '' }} value="{{ $child->id }}">{{ $menu->title.' - '.$child->title }}</option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                    @error('menu')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb20">
                                                    <label for="active_banner">Active Banner</label>
                                                    <select id="active_banner" name="active_banner"
                                                            class="form-control">
                                                        <option
                                                            {{ $page->active_banner==1 ? 'selected' : '' }} value="1">
                                                            Active
                                                        </option>
                                                        <option
                                                            {{ $page->active_banner==0 ? 'selected' : '' }} value="0">
                                                            Inactive
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-12 col-md-6 mb20">
                                                    <label for="title" class="mb20 text-left d-block">Banner</label>
                                                    <input id="banner" type="file" name="banner"
                                                           class="form-control">
                                                    @error('banner')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                @if($page->id==20)
                                                    <div class="col-12 col-md-6 mb-3 mt-3">
                                                        <label for="title" class="mb20 text-left d-block">Map</label>
                                                        <input id="map" type="file" name="map"
                                                               class="form-control">
                                                        @error('map')
                                                        <p class="input-error-validate">
                                                            {{ $message }}
                                                        </p>
                                                        @enderror
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-3 mt-3">
                                                        <label for="title" class="mb20 text-left d-block">Background for
                                                            form</label>
                                                        <input id="form_bg" type="file" name="form_bg"
                                                               class="form-control">
                                                        @error('form_bg')
                                                        <p class="input-error-validate">
                                                            {{ $message }}
                                                        </p>
                                                        @enderror
                                                    </div>

                                                @endif

                                                <div class="col-12 mb-3 mt-3">
                                                    <label for="banner_description" ِ>Banner Description</label>
                                                    <textarea class="form-control" id="banner_description"
                                                              name="banner_description">{{ $page->banner_description }}</textarea>
                                                    @error('banner_description')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3 mt-3">
                                                    <label for="description" ِ>Description</label>
                                                    <textarea class="form-control" id="description"
                                                              name="description">{{ $page->description }}</textarea>
                                                    @error('description')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-primary btn-block btn-sm">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="AddressModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Address</h5>

                </div>
                <div class="modal-body">
                    <div class="row mt-4">
                        <div class="col-12 mb-3">
                            <label for="title_modal">Title</label>
                            <input id="title_modal" class="form-control"
                                   value="">
                            <p id="title_modal_error" class="error_input_validate d-none">
                                title is required
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address_modal">Address</label>
                            <input id="address_modal" class="form-control"
                                   value="">

                        </div>
                        <div class="col-12 mb-3">
                            <label for="tel_1_modal">tel 1</label>
                            <input id="tel_1_modal" class="form-control"
                                   value="">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="tel_2_modal">tel 2</label>
                            <input id="tel_2_modal" class="form-control"
                                   value="">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="tel_3_modal">tel 3</label>
                            <input id="tel_3_modal" class="form-control"
                                   value="">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="email_modal">Email</label>
                            <input id="email_modal" class="form-control"
                                   value="">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="email_2_modal">Email 2</label>
                            <input id="email_2_modal" class="form-control"
                                   value="">
                        </div>

                        <input id="address_modal_id" value="" type="hidden">
                    </div>
                </div>

                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="AddAddressInfoToDB()">Save changes
                        </button>
                    </div>
                    <div id="message" class="alert text-center d-none p-3 w-100 mt-3"></div>
                </div>

            </div>
        </div>
    </div>
    <div id="HelpModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Help & Support</h5>
                </div>
                <div class="modal-body">
                    <div class="row mt-4">
                        <div class="col-12 mb-3">
                            <label for="title_help_modal">Title</label>
                            <input id="title_help_modal" class="form-control"
                                   value="">
                            <p id="title_help_modal_error" class="error_input_validate d-none">
                                title is required
                            </p>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description_help_modal">Description</label>
                            <textarea rows="5" id="description_help_modal" class="form-control"></textarea>

                        </div>
                        <div class="col-12 mb-3">
                            <label for="link_help_modal">Link</label>
                            <input id="link_help_modal" class="form-control"
                                   value="">
                        </div>

                        <input id="address_modal_id" value="" type="hidden">
                    </div>
                </div>

                <div class="modal-footer">
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="HelpSupportInfoToDB()">Save changes
                        </button>
                    </div>

                    <div id="help_message" class="alert text-center d-none p-3 w-100 mt-3"></div>
                </div>

            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .small-image {
            width: 100px;
            height: auto;
            margin: 10px auto;
        }

        #cke_description .cke_contents {
            height: 700px !important;
        }

        .modal-dialog {
            width: 500px;
        }

        .error_input_validate {
            font-size: 9pt;
            color: red;
        }

        .mr-2 {
            margin-right: 20px;
        }

        tr {
            text-align: center;
        }

        #addresses_section {
            margin-bottom: 50px;
        }
        #help_section {
            margin-bottom: 50px;
        }
    </style>
@endpush
@section('script')
    <script>
        CKEDITOR.replace('description', {
            language: 'en',
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('banner_description', {
            language: 'en',
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });


        function AddressModal(address_id = null) {
            // Clear all input fields in one go
            const fields = ['title_modal', 'address_modal', 'tel_1_modal', 'tel_2_modal', 'tel_3_modal', 'email_modal', 'email_2_modal'];
            fields.forEach(field => $('#' + field).val(''));

            $('#AddressModal').modal('show');
            $('#address_modal_id').val(address_id);

            if (address_id != null) {
                const data = {
                    title_modal: $('#address_modal_' + address_id).attr('data-title'),
                    address_modal: $('#address_modal_' + address_id).attr('data-address'),
                    tel_1_modal: $('#address_modal_' + address_id).attr('data-tel-1'),
                    tel_2_modal: $('#address_modal_' + address_id).attr('data-tel-2'),
                    tel_3_modal: $('#address_modal_' + address_id).attr('data-tel-3'),
                    email_modal: $('#address_modal_' + address_id).attr('data-email'),
                    email_2_modal: $('#address_modal_' + address_id).attr('data-email-2')
                };

                // Set each field's value based on data object
                Object.keys(data).forEach(field => $('#' + field).val(data[field]));
            }
        }

        function AddressHelp(help_id = null) {
            // Clear all input fields in one go
            const fields = ['title_help_modal', 'description_help_modal', 'link_help_modal'];
            fields.forEach(field => $('#' + field).val(''));
            $('#HelpModal').modal('show');
            $('#HelpModal_id').val(help_id);

            if (help_id != null) {
                const data = {
                    title_help_modal: $('#help_modal_' + help_id).attr('data-title'),
                    description_help_modal: $('#help_modal_' + help_id).attr('data-description'),
                    link_help_modal: $('#help_modal_' + help_id).attr('data-link'),
                };

                // Set each field's value based on data object
                Object.keys(data).forEach(field => $('#' + field).val(data[field]));
            }
        }

        function removeModal(address_id) {
            // نمایش پیام تأیید به کاربر
            if (!confirm("Are you sure ?")) {
                return; // در صورت عدم تأیید، از تابع خارج می‌شود
            }

            // در صورت تأیید کاربر، درخواست حذف ارسال می‌شود
            $.ajax({
                url: "{{ route('admin.contact.delete_address') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    address_id: address_id
                },
                dataType: 'json',
                method: 'POST',
                success: function (data) {
                    if (data[0] == 1) {
                        window.location.reload();
                    }
                    if (data[0] == 0) {
                        alert('Error');
                    }
                },
                error: function () {
                    alert('Server Error');
                }
            });
        }

        function removeHelpModal(id) {
            // نمایش پیام تأیید به کاربر
            if (!confirm("Are you sure ?")) {
                return; // در صورت عدم تأیید، از تابع خارج می‌شود
            }

            // در صورت تأیید کاربر، درخواست حذف ارسال می‌شود
            $.ajax({
                url: "{{ route('admin.contact.delete_help_support') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                dataType: 'json',
                method: 'POST',
                success: function (data) {
                    if (data[0] == 1) {
                        window.location.reload();
                    }
                    if (data[0] == 0) {
                        alert('Error');
                    }
                },
                error: function () {
                    alert('Server Error');
                }
            });
        }


        function AddAddressInfoToDB() {
            $('#title_modal_error').addClass('d-none');
            let title_modal = $('#title_modal').val();
            if (title_modal.length == 0) {
                $('#title_modal_error').removeClass('d-none');
                return
            }
            let address_modal = $('#address_modal').val();
            let tel_1_modal = $('#tel_1_modal').val();
            let tel_2_modal = $('#tel_2_modal').val();
            let tel_3_modal = $('#tel_3_modal').val();
            let email_modal = $('#email_modal').val();
            let email_2_modal = $('#email_2_modal').val();
            let address_modal_id = $('#address_modal_id').val();
            $.ajax({
                url: "{{ route('admin.contact.save_address') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    title_modal: title_modal,
                    address_modal: address_modal,
                    tel_1_modal: tel_1_modal,
                    tel_2_modal: tel_2_modal,
                    tel_3_modal: tel_3_modal,
                    email_modal: email_modal,
                    email_2_modal: email_2_modal,
                    address_modal_id: address_modal_id,
                },
                dataType: 'json',
                method: 'POST',
                success: function (data) {
                    if (data[0] == 1) {
                        $('#message').text(data[1]);
                        $('#message').removeClass('d-none');
                        $('#message').addClass('alert-success');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000)
                    }
                    if (data[0] == 0) {
                        $('#message').text(data[1]);
                        $('#message').removeClass('d-none');
                        $('#message').addClass('alert-danger');
                    }
                },
            })
        }

        function HelpSupportInfoToDB() {
            let title_help_modal = $('#title_help_modal').val();
            let description_help_modal = $('#description_help_modal').val();
            let link_help_modal = $('#link_help_modal').val();

            if (title_help_modal.length == 0) {
                $('#title_help_modal_error').removeClass('d-none');
                return
            }

            $.ajax({
                url: "{{ route('admin.contact.save_help_support') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    title_help_modal: title_help_modal,
                    description_help_modal: description_help_modal,
                    link_help_modal: link_help_modal,
                },
                dataType: 'json',
                method: 'POST',
                success: function (data) {
                    if (data[0] == 1) {
                        $('#help_message').text(data[1]);
                        $('#help_message').removeClass('d-none');
                        $('#help_message').addClass('alert-success');
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000)
                    }
                    if (data[0] == 0) {
                        $('#help_message').text(data[1]);
                        $('#help_message').removeClass('d-none');
                        $('#help_message').addClass('alert-danger');
                    }
                },
            })
        }

    </script>
@endsection

