
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
 

                <div class="mb-3">
                    <span>Username:</span>
                 <input  type="text" class="form-control mb-3" id="user_name">
                 
                </div>
                <div class="mb-3" style="width: 70%;margin: 10px auto">
                    <button onclick="randString()" class="w-100 btn btn-success mb-3" type="button">
                        Create a Password
                    </button>
                    <input readonly type="text" class="form-control mb-3" id="new_password" data-character-set="a-z,A-Z,0-9,#">
                    <p id="new_password_copied" style="text-align: left;" class="d-none mb-3">
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
