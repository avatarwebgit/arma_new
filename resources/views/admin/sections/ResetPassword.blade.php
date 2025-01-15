
<div class="modal fade" id="reset_password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div style="max-width: 500px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h3>
                    Reset Password
                </h3>
                <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"></i>

            </div>
            <div class="modal-body p-5 row text-center">
                 <div class="d-flex mb-3 justify-content-between">
{{--                    <div>--}}
{{--                        <input type="radio" name="role" id="Admin" value="1">--}}
{{--                        <label for="Admin">Admin</label>--}}
{{--                    </div>--}}
                    <div class="ml5">
                        <input  type="radio" name="role-reset-password" id="Seller-reset-password" value="2">
                        <label for="Seller-reset-password">Seller</label>

                    </div>
                    <div class="ml5">
                        <input  type="radio" name="role-reset-password" id="Buyer-reset-password" value="3">
                        <label for="Buyer-reset-password">Buyer</label>
                    </div>
<!--                     <div class="ml5">
                        <input onclick="ShowName('Broker')" type="radio" name="role" id="Broker" value="6">
                        <label for="Broker">Broker</label>
                    </div> -->
                </div>

                <div class="mb-3" style="width: 70%;margin: 10px auto">
                    <span>Username:</span>
                 <input  type="text" class="form-control mb-3" id="userName">
<input type="hidden" id="user_id_reset_password">
                 
                </div>
                <div class="mb-3" style="width: 70%;margin: 10px auto">
                    <button onclick="CreateNewPassword()" class="w-100 btn btn-success mb-3" type="button">
                        Create a Password
                    </button>
                    <input readonly type="text" class="form-control mb-3" id="new_password_reset" data-character-set="a-z,A-Z,0-9,#">
                    <p id="new_password_reset_copied" style="text-align: left;" class="d-none mb-3">
                        password was copied
                    </p>
                    <button onclick="UpdatePasswordUser()" class="w-100 btn btn-info mb-3" type="button">
                        Update Password
                    </button>
                </div>

                <input type="hidden" id="user_id">
            </div>
        </div>
    </div>
</div>
