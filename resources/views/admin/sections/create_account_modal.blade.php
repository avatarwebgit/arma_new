<div class="modal fade" id="create_account_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div style="max-width: 500px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h3>
                    Create Account
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
                        <input onclick="ShowName('Seller')" type="radio" name="role" id="Seller" value="2">
                        <label for="Seller">Seller</label>

                    </div>
                    <div class="ml5">
                        <input onclick="ShowName('Buyer')" type="radio" name="role" id="Buyer" value="3">
                        <label for="Buyer">Buyer</label>
                    </div>
<!--                     <div class="ml5">
                        <input onclick="ShowName('Broker')" type="radio" name="role" id="Broker" value="6">
                        <label for="Broker">Broker</label>
                    </div> -->
                </div>
                <div class="mb-3">
                    <strong>Status:</strong>
                    <strong id="role"></strong>
                </div>
                <div class="mb-3">
                    <span>Username:</span>
                    <span id="user_name"></span>
                </div>
                <div class="mb-3" style="width: 70%;margin: 10px auto">
                    <button onclick="randString()" class="w-100 btn btn-success mb-3" type="button">
                        Create a Password
                    </button>
                    <input readonly type="text" class="form-control mb-3" id="new_password" data-character-set="a-z,A-Z,0-9,#">
                    <p id="new_password_copied" style="text-align: left;" class="d-none mb-3">
                        password was copied
                    </p>
                    <button onclick="CopyUserName()" class="w-100 btn btn-info mb-3" type="button">
                        Copy Password
                    </button>
                </div>

                <input type="hidden" id="user_id">
            </div>
        </div>
    </div>
</div>
