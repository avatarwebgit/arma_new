<div class="modal fade" id="reset_password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div style="max-width: 650px !important;" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="auth-form">
                @csrf
                <div class="row">
                    <div class="col-12 position-relative">
                        <i style="position: absolute;top:0;right: 10px" data-dismiss="modal" aria-label="Close"
                           class="fa fa-times-circle fa-2x"></i>
                        <h3 class="text-center">Reset Password</h3>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="alert_reset_password alert alert-success d-none">
                            Email was sent.Please check your email box
                        </div>
                        <div class="alert_reset_password2 alert alert-danger d-none">
                            Your Account is Inactive, Please Contact Admin
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="email_reset_password">Email</label>
                        <input id="email_reset_password" type="email"
                               class="form-control"
                               name="email" value="{{ old('email') }}"
                               placeholder="{{ __('Enter email address') }}"
                               required autocomplete="email" autofocus>
                        <p id="email_reset_password_error" class="d-none error-message mt-2">

                        </p>

                    </div>
                    <div class="col-12">
                        <button id="SubmitResetPasswordModalBtn" onclick="SubmitResetPasswordModal()"
                                type="button" class="btn btn-primary">Reset Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
