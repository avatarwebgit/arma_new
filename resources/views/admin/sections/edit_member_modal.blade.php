<div class="modal fade" id="edit_member_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div style="max-width: 760px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h3>
                    Edit Account
                </h3>
                <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"></i>

            </div>
            <form id="member_form_update" method="post" action="{{ route('admin.user.member.update',['user'=>$user->id]) }}" class="modal-body p-5 row">
                @method('put')
                @csrf
                <div class="d-flex justify-content-between align-items-center mb-3">
                    {{--                    <div>--}}
                    {{--                        <input type="radio" name="role" id="Admin" value="1">--}}
                    {{--                        <label for="Admin">Admin</label>--}}
                    {{--                    </div>--}}
<div>
    <div class="ml5 create_account_radio Members">
        <input {{ $user->hasRole('Members') ? 'checked' : '' }} type="radio" name="role" id="Members" value="Members">
        <label for="Members">Member</label>

    </div>
    <div class="ml5 create_account_radio Representatives">
        <input {{ $user->hasRole('Representatives') ? 'checked' : '' }} type="radio" name="role" id="Representatives" value="Representatives">
        <label for="Representatives">Representatives</label>
    </div>
{{--    <div class="ml5 create_account_radio Brokers">--}}
{{--        <input type="radio" name="role" id="Brokers" value="Brokers">--}}
{{--        <label for="Brokers">Brokers</label>--}}
{{--    </div>--}}
</div>
                    <div class="w-50 d-flex align-items-center">
                        <span style="margin-right: 5px">Country</span>
                        <select name="company_country_edit" id="company_country_edit" class="form-control form-control-sm">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option {{ $country->countryName==$user->company_country ? 'selected' : '' }} value="{{ $country->countryName }}">{{ $country->countryName }}</option>
                            @endforeach
                        </select>
                        <p id="company_country_edit_error" class="error-message d-none">

                        </p>
                    </div>
                </div>
                <div>
                    <h3 class="text-center text-danger mb-2">Access Level</h3>
                    <div class="row">


                        @foreach($permission_groups as $permission_group)
                            <div class="col-12 col-md-4 mb-3">
                                <strong class="text-info">
                                    + {{ $permission_group[0]->group }}
                                </strong>
                                @foreach($permission_group as $permission)
                                    <div class="ml5">
                                        <input onclick="FullAccess(this)"
                                            {{ in_array($permission->id,$user_permissions->pluck('id')->toArray()) ? 'checked' : '' }}
                                            style="cursor: pointer" type="checkbox" name="{{ $permission->name }}"
                                               id="{{ $permission->name }}"
                                               value="{{ $permission->id }}">
                                        <label style="cursor: pointer" class="{{  $permission->name=='Full-Access' ? 'text-danger' : '' }}"
                                               for="{{ $permission->name }}">{{ $permission->display_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3" style="width: 40%;margin: 10px auto">
                                <label>Enter a Email</label>
                                <div class="d-flex justify-content-center align-items-center ">
                                    <input name="email_edit" type="text" class="form-control mb-3" id="email_edit" value="{{ $email_name }}">
                                    <span class="mb-3 ml5">@armaitimex.com</span>
                                </div>
                                <p id="email_error_edit" class="error-message d-none">
                                    Email is invalid
                                </p>

                                <button onclick="randString2()" class="w-100 btn btn-success mb-3" type="button">
                                    Reset Password
                                </button>
                                <input type="text" class="form-control mb-3" id="new_password2_edit" name="new_password" data-character-set="a-z,A-Z,0-9,#">
                                <p id="new_password_copied2_edit" style="text-align: left;" class="d-none mb-3">
                                    password was copied
                                </p>
                                <button onclick="UpdateMember({{ $user->id }})" class="w-100 btn btn-info mb-3" type="button">
                                    Update & Copy Password
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
