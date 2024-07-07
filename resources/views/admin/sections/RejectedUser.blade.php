<div class="modal fade" id="RejectedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div style="max-width: 900px" class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h3>
                    Rejected User
                </h3>
                <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"></i>

            </div>
            <div class="modal-body p-5 row">
                <div id="reject_user_question" class="d-flex justify-content-between">
                    <div>
                        Reject User ?
                    </div>
                    <div class="d-flex">
                        <div>
                            <label>Yes</label>
                            <input type="radio" name="is_reject" value="1">
                        </div>
                        <div style="margin-left: 10px">
                            <label>No</label>
                            <input type="radio" name="is_reject" value="0">
                        </div>
                    </div>
                </div>
                <p id="is_reject_error" class="d-none error-message">
                    please select Yes for Send Request
                </p>
                <div class="mt-3">
                    <label for="Reject_reason">
                        Reason for Reject
                    </label>
                    <textarea id="Reject_reason" name="Reject_reason" class="form-control mt-2"></textarea>
                    <p id="Reject_reason_error" class="error-message d-none">
                        Minimum Character is 20
                    </p>
                </div>
                <div id="reject_user_question_button" class="d-flex justify-content-center mt-3">
                    <button onclick="SendRejectReason()" class="btn btn-success">Send</button>
                </div>

                <input type="hidden" id="user_id">
            </div>
        </div>
    </div>
</div>
