@extends('admin.layouts.main')

@section('title')
    Edit User Information
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('#new_password').val('');
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

        function cancelSavePassword(){
            $('#old_password').val('');
            $('#new_password').val('');
            $('#repeat_password').val('');
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
                        <div class="col-12 {{ $type!=null ? 'col-xl-3' : 'col-xl-6' }} ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="settings-profile">
                                        <form method="POST" action="{{ route('admin.user.update', ['user' => $user->id]) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')

                                            @if($type != null)
                                                <h5 class="mt-4">Update Password</h5>
                                                <hr>
                                                <div class="row">
                                                    <div class="form-group col-12">
                                                        <label for="old_password" class="mb-1">Old Password</label>
                                                        <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" required>
                                                        @error('old_password')
                                                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                                                        @enderror
                                                    </div> <div class="form-group col-12">
                                                        <label for="new_password" class="mb-1">New Password</label>
                                                        <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required>
                                                        @error('new_password')
                                                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <label for="repeat_password" class="mb-1">Repeat Password</label>
                                                        <input id="repeat_password" type="password" class="form-control @error('repeat_password') is-invalid @enderror" name="repeat_password" required>
                                                        @error('repeat_password')
                                                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mt-4 d-flex justify-content-between">
                                                    <button class="btn btn-success btn-sm mb-2" type="submit">change password</button>
                                                    <button onclick="cancelSavePassword()" class="btn btn-dark btn-sm mb-2">cancel</button>
                                                </div>
                                            @else
                                                <h5 class="mt-4">Update Profile</h5>
                                            <hr>
                                                <div class="row">
                                                    <div class="form-group col-12 text-center">
                                                        <div class="user-img mb-2">
                                                            <img src="{{ imageExist(env('UPLOAD_IMAGE_PROFILE'),auth()->user()->image) }}" alt="{{ auth()->user()->name }}" class="rounded-circle" width="50">
                                                        </div>
                                                        <h5>{{ auth()->user()->user_id }}</h5>
                                                    </div>

                                                    <div class="form-group col-12">
                                                        <label for="profile_picture" class="mb-1">Profile Picture</label>
                                                        <input type="file" class="form-control" name="image" id="image">
                                                        @error('image')
                                                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                                                        @enderror
                                                    </div>

                                                    @if($user->Roles[0]->name == 'seller')
                                                        @include('admin.users.user_seller_info')
                                                    @else
                                                        @include('admin.users.admin_user_info')
                                                    @endif



                                                </div>
                                                <div class="col-md-12 mt-4 text-center">
                                                    <button class="btn btn-info btn-sm mb-2" type="submit">Update</button>
                                                </div>
                                            @endif


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

