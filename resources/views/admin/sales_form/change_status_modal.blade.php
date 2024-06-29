<!-- Modal -->
<div class="modal fade" id="change_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center position-relative">

                <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"
                   style="position: absolute;right: 10px;top: 10px"></i>
                <h3>
                    Status
                </h3>

            </div>
            <div id="modal_body" class="modal-body p-5 row">
                <div class="d-flex justify-content-center">
                    <button data-id="4" class="change_status_btn">Reject</button>
                    <button id="pending_button" data-id="3" class="change_status_btn">Pending</button>
                    <button data-id="5" class="change_status_btn">Confirm</button>
                </div>
                <div id="approved_box" class="mb-3 mt-3 status_options d-none">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="safety_product" class="mb-2">Offer Deposit</label>
                        </div>
                        <div>
                            <div class="form-check form-check-inline mr-3">
                                <input onclick="changeDeposit(this)"
                                       class="form-check-input"
                                       type="radio"
                                       name="deposit"
                                       value="1">
                                <label class="form-check-label">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input onclick="changeDeposit(this)"
                                       class="form-check-input"
                                       type="radio"
                                       name="deposit"
                                       value="0">
                                <label class="form-check-label">No</label>
                            </div>
                        </div>
                    </div>
                    <div id="deposit_input" class="mb-3 mt-3 status_options d-none row">
                        <div class="mt-3 mb-3 col-6">
                            <label for="deposit" class="form-label">Amount</label>
                            <input class="form-control" id="deposit">
                        </div>
                        <div class="mt-3 mb-3 col-6">
                            <label for="currency" class="form-label">
                                Currency
                            </label>
                            <input class="form-control" id="currency">
                        </div>
                    </div>
                </div>
                <div id="message_box" class="mb-3 mt-3 status_options d-none">
                    <div class="mt-3 mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <input type="hidden" name="modal_form_id" id="modal_form_id">
            <input type="hidden" name="status_id" id="status_id">
            <input type="hidden" name="form_change_status" id="form_change_status">
            {{ csrf_field() }}
            <div class="modal-footer d-flex justify-content-center">
                {{--                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>--}}
                <button type="button" class="btn btn-success save_btn" onclick="SaveChangeStatus()">
                    Update
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Edit_Currency" tabindex="-1" role="dialog" aria-labelledby="Edit_Currency"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center position-relative">
                <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"
                   style="position: absolute;right: 10px;top: 10px"></i>
                <h3>
                    Edit Amount
                </h3>
            </div>
            <div id="modal_body" class="modal-body p-5 row">
                <div id="deposit_input" class="mb-3 mt-3  row">
                    <div class="mt-3 mb-3 col-6">
                        <label for="amount_cash_pending" class="form-label">Amount</label>
                        <input class="form-control" type="number" id="amount_cash_pending">
                    </div>
                    <div class="mt-3 mb-3 col-6">
                        <label for="currency_cash_pending" class="form-label">
                            Currency
                        </label>
                        <input class="form-control" id="currency_cash_pending">
                    </div>
                </div>
                <input id="id_cash_pending" type="hidden">
            </div>
            <div class="modal-footer d-flex justify-content-center">
                {{--                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>--}}
                <button onclick="UpdateCashPending()" type="button" class="btn btn-success save_btn">
                    Edit
                </button>
            </div>
        </div>
    </div>
</div>

