<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div style="max-width: 500px !important;" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="auth-form">
                <div class="modal-header position-relative" style="border-bottom: none !important;">
                    <i style="position: absolute;top:0;right: 0" data-dismiss="modal" aria-label="Close"
                       class="fa fa-times-circle fa-2x"></i>
                </div>
                <h4 style="display: block;text-align: center" class="text-center mt-3">
                    Sign In
                </h4>

                <div class="row">
                    <div class="form-group col-12">
                        <label for="email">Username (Email)</label>
                        <input id="email" type="email"
                               class="form-control"
                               name="email" value="{{ old('email') }}"
                               required autocomplete="email" autofocus>

                        <p id="email_error" class="d-none error-message mt-2">

                        </p>
                    </div>
                    <div class="form-group col-12 position-relative">
                        <label for="password">Password</label>
                        <input id="password"
                            type="password"
                            class="form-control" name="password"
                            required
                            autocomplete="current-password">
                        <i onclick="ShowPass(this)" id="fa-eye" class="fa fa-eye fa-2x text-dark password-eye-icon cursor-pointer"></i>
                        <i onclick="HidePass(this)" id="fa-eye-slash" class="password-eye-icon fa fa-eye-slash fa-2x cursor-pointer text-dark d-none"></i>
                        <p id="password_error" class="d-none error-message mt-2">

                        </p>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div class="text-white mb-3">
                                Don`t have an account ?
                                <a onclick="OpenModalRegister()"  style="color: white !important;cursor: pointer">
                                    {{ __('Register now') }}
                                </a>
                            </div>
                            <div class="text-right text-white mb-3">
                                <a onclick="ResetPassword()"  style="color: white !important;cursor: pointer">
                                    {{ __('Forgot Password?') }}
                                </a>
                            </div>
                        </div>
                        <div class="col-12 d-flex w-100">
                            <button onclick="LoginFormSubmit(this)" type="button" class="btn btn-primary"
                                    style="padding: 2px 40px;height: 50px;margin: 0 auto">{{ __('Log In') }}
                            </button>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="BlockUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div style="max-width: 500px !important;" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="auth-form">
                <div class="modal-header position-relative" style="border-bottom: none !important;">
                    <i style="position: absolute;top:0;right: 0" data-dismiss="modal" aria-label="Close"
                       class="fa fa-times-circle fa-2x"></i>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger text-center">
                            Your Account has been Blocked
                            <br>
                            Contact your administrator
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
