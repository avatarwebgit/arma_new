@extends('admin.layouts.main')

@section('title')
    {{ $user_status }} Users
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('#new_password').val(' ');
        })

        // Generate a Password string
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

        CKEDITOR.replace('message', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

        CKEDITOR.replace('note', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="tab-content" id="v-pills-tabContent">
                <div id="settings-profile"
                     aria-labelledby="settings-profile-tab">
                    <div class="row">
                        <div class="col-12 col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <h3>Edit User</h3>
                                        <hr>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST"
                                              action="{{ route('admin.user.update',['type'=>$type,'user'=>$user->id]) }}">
                                            @csrf
                                            @method('put')
                                            <div class="row">
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="commodity" class="mb-1">Commodities *</label>
                                                    <select disabled name="commodity" id="commodity"
                                                            class="form-control">
                                                        <option value="">Select Commodity</option>
                                                        @foreach($commodities as $commodity)
                                                            <option
                                                                {{ $user->commodity==$commodity->id ? 'selected' : ''  }} value="{{ $commodity->id }}">
                                                                {{ $commodity->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('commodity')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="company_name" class="mb-1">Company Name *</label>
                                                    <input disabled
                                                           id="company_name"
                                                           type="text"
                                                           class="form-control @error('company_name') is-invalid @enderror"
                                                           name="company_name"
                                                           value="{{ $user->company_name }}" required>
                                                    @error('company_name')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="mt-3  text-left">
                                                        Company Address
                                                        <hr>
                                                    </h5>
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="company_address" class="mb-1">address *</label>
                                                    <input disabled
                                                           id="company_address"
                                                           type="text"
                                                           class="form-control @error('company_address') is-invalid @enderror"
                                                           name="company_address"
                                                           value="{{$user->company_address }}" required>

                                                    @error('company_address')
                                                    <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="company_post_zip_code" class="mb-1">post/zip code
                                                        *</label>
                                                    <input disabled
                                                           id="company_post_zip_code"
                                                           type="text"
                                                           class="form-control @error('company_post_zip_code') is-invalid @enderror"
                                                           name="company_post_zip_code"
                                                           value="{{ $user->company_post_zip_code }}" required>

                                                    @error('company_post_zip_code')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="company_city" class="mb-1">company city</label>
                                                    <input disabled
                                                           id="company_city"
                                                           type="text"
                                                           class="form-control @error('company_city') is-invalid @enderror"
                                                           name="company_city"
                                                           value="{{ $user->company_city }}">

                                                    @error('company_city')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="company_state" class="mb-1">State (US entities
                                                        only)</label>
                                                    <input disabled
                                                           id="company_state"
                                                           type="text"
                                                           class="form-control @error('company_state') is-invalid @enderror"
                                                           name="company_state"
                                                           value="{{ $user->company_state }}">
                                                    @error('company_state')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="company_country" class="mb-1">Select Country</label>
                                                    <select disabled name="company_country" id="company_country"
                                                            class="form-control">
                                                        <option value="">Select Country</option>
                                                        @foreach($countries as $country)
                                                            <option
                                                                {{ $user->company_country==$country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('company_country')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="mt-3">
                                                        Company Contact
                                                        <hr>
                                                    </h5>
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="company_phone" class="mb-1">Main Telephone Number
                                                        *</label>
                                                    <input disabled
                                                           id="company_phone"
                                                           type="text"
                                                           class="form-control @error('company_phone') is-invalid @enderror"
                                                           name="company_phone"
                                                           value="{{ $user->company_phone }}" required>

                                                    @error('company_phone')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="company_website" class="mb-1">Website</label>
                                                    <input disabled
                                                           id="company_website"
                                                           type="text"
                                                           class="form-control @error('company_website') is-invalid @enderror"
                                                           name="company_website"
                                                           value="{{ $user->company_website }}" required>

                                                    @error('company_website')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="company_email" class="mb-1">Email</label>
                                                    <input disabled
                                                           id="company_email"
                                                           type="email"
                                                           class="form-control @error('company_email') is-invalid @enderror"
                                                           name="company_email"
                                                           value="{{ $user->company_email }}" required>
                                                    @error('company_email')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h5>
                                                        Master User Details
                                                        <hr>
                                                    </h5>
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="user_type" class="mb-1">User Type *</label>
                                                    <select disabled
                                                            id="user_type"
                                                            type="text"
                                                            class="form-control @error('user_type') is-invalid @enderror"
                                                            name="user_type">
                                                        <option value="">Select User Type</option>
                                                        @foreach($types as $type)
                                                            <option
                                                                {{ $user->user_type==$type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('user_type')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="salutation" class="mb-1">Salutation *</label>
                                                    <select disabled id="salutation"
                                                            type="text"
                                                            class="form-control @error('salutation') is-invalid @enderror"
                                                            name="salutation">
                                                        <option value="">Select</option>
                                                        @foreach($salutation as $item)
                                                            <option
                                                                {{ $user->salutation==$item->id  ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('salutation')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="full_name" class="mb-1">Full Name *</label>
                                                    <input disabled
                                                           id="full_name"
                                                           type="text"
                                                           class="form-control @error('full_name') is-invalid @enderror"
                                                           name="full_name"
                                                           value="{{ $user->full_name }}"
                                                           required
                                                    >
                                                    @error('full_name')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="company_title" class="mb-1">Company Title *</label>
                                                    <input disabled
                                                           id="company_title"
                                                           type="text"
                                                           class="form-control @error('company_title') is-invalid @enderror"
                                                           name="company_title"
                                                           value="{{ $user->company_title }}"
                                                           required
                                                    >
                                                    @error('company_title')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="function_in_company" class="mb-1">Function in
                                                        company</label>
                                                    <select disabled
                                                            id="function_in_company"
                                                            type="text"
                                                            class="form-control @error('function_in_company') is-invalid @enderror"
                                                            name="function_in_company">
                                                        <option value="">Select</option>
                                                        @foreach($companyFunction as $item)
                                                            <option
                                                                {{ $user->function_in_company==$item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('function_in_company')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="email" class="mb-1">Email *</label>
                                                    <input disabled
                                                           id="email"
                                                           type="email"
                                                           class="form-control @error('email') is-invalid @enderror"
                                                           name="email"
                                                           value="{{ $user->email }}"
                                                           required>
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="skype" class="mb-1">Skype</label>
                                                    <input disabled
                                                           id="skype"
                                                           type="text"
                                                           class="form-control @error('skype') is-invalid @enderror"
                                                           name="skype" value="{{ $user->skype }}">
                                                    @error('skype')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-12 col-md-6">
                                                    <label for="whatsapp" class="mb-1">whatsapp</label>
                                                    <input disabled
                                                           id="whatsapp"
                                                           type="text"
                                                           class="form-control @error('whatsapp') is-invalid @enderror"
                                                           name="whatsapp" value="{{ $user->whatsapp }}">
                                                    @error('whatsapp')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mt-4">


                                                <div class="col-md-6 mb-2">
                                                    <label for="role_request_id">Role Request</label>
                                                    <select
                                                        id="role_request_id"
                                                        type="text"
                                                        class="form-control"
                                                        name="role_request_id">
                                                        @if($user->type!='Admin')
                                                            <option value="0">Nothing</option>
                                                            @foreach($userTypes as $type)
                                                                <option
                                                                    {{ $user->role_request_id==$type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="1">Admin</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label for="status">User Status</label>
                                                    <select name="active_status" id="status"
                                                            class="form-control">
                                                        @foreach($userStatus as $status)
                                                            <option
                                                                {{ $user->active_status == $status->id ? 'selected' : ' ' }} value="{{ $status->id }}">{{ $status->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 mb-3 mb-2">
                                                    <label for="note">Note:</label>
                                                    <textarea rows="5" id="note" name="note"
                                                              class="form-control">{{ $user->note }}</textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn-info btn-sm mb-2" type="submit">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @can('user-edit')
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <h3>
                                                Reset Password
                                            </h3>
                                            <hr>
                                        </div>
                                        <div class="settings-profile">
                                            <form method="POST"
                                                  action="{{ route('admin.user.reset_password',['user'=>$user->id]) }}">
                                                @csrf
                                                <div class="row mt-4">
                                                    <div class="col-12 position-relative mb-3">
                                                        <label for="new_password">Generate Password</label>
                                                        <input name="new_password" id="new_password"
                                                               class="form-control"
                                                               data-character-set="a-z,A-Z,0-9,#">
                                                        @error('new_password')
                                                        <p class="input-error-validate position-absolute">
                                                            {{ $message }}
                                                        </p>
                                                        @enderror
                                                        <button style="bottom: 0;right: 0" onclick="randString()"
                                                                class="btn btn-info position-absolute"
                                                                type="button">
                                                            Generate Password
                                                        </button>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-info btn-sm mb-2" type="submit">
                                                            Reset Password
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </div>
                        @can('user')
                            <div class="col-12 col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <h3>Send Message</h3>
                                            <hr>
                                        </div>
                                        <div class="settings-profile">
                                            <form method="POST"
                                                  action="{{ route('admin.user.sendMessage',['user'=>$user->id]) }}">
                                                @csrf
                                                <div class="row mt-4">
                                                    <div class="col-md-6 mb-2">
                                                        <label for="title">Subject</label>
                                                        <input id="title" type="text" name="title"
                                                               class="form-control" value="{{ old('title') }}">
                                                        @error('title')
                                                        <p class="input-error-validate">
                                                            {{ $message }}
                                                        </p>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <label for="message">Message:</label>
                                                        <textarea rows="10" id="message" name="message"
                                                                  class="form-control">{{ old('message') }}</textarea>
                                                        @error('message')
                                                        <p class="input-error-validate">
                                                            {{ $message }}
                                                        </p>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-info btn-sm mb-2" type="submit"> Send
                                                            Email
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <h3>
                                                Role & Permissions
                                            </h3>
                                            <hr>
                                        </div>
                                        <div class="settings-profile">
                                            <form method="POST"
                                                  action="{{ route('admin.user.update_role',['user'=>$user->id]) }}">
                                                @csrf
                                                <div class="row mt-4">
                                                    <div class="form-group col-md-3">
                                                        <label for="role">Roles</label>
                                                        <select class="form-control" name="role" id="role">
                                                            <option value="">-</option>
                                                            @foreach ($roles as $role)
                                                                <option
                                                                    value="{{ $role->name }}" {{ in_array($role->id , $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="accordion col-md-12 mt-3" id="accordionPermission">
                                                        <div class="card">
                                                            <div class="card-header p-1" id="headingOne">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-link btn-block text-right"
                                                                            type="button" data-toggle="collapse"
                                                                            data-target="#collapsePermission"
                                                                            aria-expanded="true"
                                                                            aria-controls="collapseOne">
                                                                        Permissions
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapsePermission" class="collapse"
                                                                 aria-labelledby="headingOne"
                                                                 data-parent="#accordionPermission">
                                                                <div class="card-body row">
                                                                    @foreach ($permissions as $permission)
                                                                        <div class="form-group form-check col-md-3">
                                                                            <input type="checkbox"
                                                                                   class="form-check-input"
                                                                                   id="permission_{{ $permission->id }}"
                                                                                   name="{{ $permission->name }}"
                                                                                   value="{{ $permission->name }}"
                                                                                {{ in_array( $permission->id , $user->permissions->pluck('id')->toArray() ) ? 'checked' : '' }}
                                                                            >
                                                                            <label class="form-check-label mr-3"
                                                                                   for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="can_bid"
                                                                   name="can_bid" {{ $user->can_bid==1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="can_bid">this User Can
                                                                Bid</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-info btn-sm mb-2" type="submit">
                                                            submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

