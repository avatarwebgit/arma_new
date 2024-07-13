<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div style="max-width: 650px !important;" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="auth-form">
                <div class="modal-header position-relative" style="border-bottom: none !important;">
                    <h4 class="text-center mt-3">
                        Direct Hedge session has expired
                        Please log in again
                    </h4>
                    <i style="position: absolute;top:0;right: 0" data-dismiss="modal" aria-label="Close"
                       class="fa fa-times-circle fa-2x"></i>

                </div>

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
                    <div class="form-group col-12">
                        <label for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            class="form-control" name="password"
                            required
                            autocomplete="current-password">
                        <p id="password_error" class="d-none error-message mt-2">

                        </p>
                    </div>
                    @if (Route::has('password.request'))
                        <div class="col-12 d-flex justify-content-end align-items-center">

                            <div class="text-right text-white mb-3">
                                <a onclick="ResetPassword()"  style="color: white !important;cursor: pointer">
                                    {{ __('Forgot Password?') }}
                                </a>
                            </div>
                        </div>
                        <div class="col-12 d-flex w-100">
                            <button onclick="LoginFormSubmit(this)" type="button" class="btn btn-primary w-100"
                                    style="padding: 5px 20px;height: 50px">{{ __('Log In') }}
                            </button>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
