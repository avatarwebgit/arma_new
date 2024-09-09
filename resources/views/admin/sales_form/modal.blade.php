<!-- Modal -->
<div class="modal fade" id="NeedToSubmitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 800px">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;position: relative">
                <h5 style="width: 100%;text-align: center">
                    Preview Sales Offer Form
                </h5>
                <i style="position: absolute;right: 40px;top: 10px" data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"></i>
            </div>

            <div id="modal_body" class="modal-body p-5 row">

            </div>
            <div class="modal-footer">
                <input id="modal_form_id" type="hidden" value="">
                <button onclick="CloseModal()"   type="button"  data-dismiss="modal">Cancel</button>
                <button onclick="CloseModal()"   type="button"  data-dismiss="modal">Edit</button>
                <button onclick="Final_Submit()" type="button">Send</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="show_modal_form_exists" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="get" action="" class="modal-content">
            <div class="modal-header justify-content-end">
                    <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"></i>
            </div>
{{--            <div class="modal-body p-5">--}}
{{--               Use Previous Sales Form?--}}
{{--            </div>--}}
            <div class="modal-footer justify-content-center">
               <div class="show_modal_form_exists_div_btn">
                   <button type="submit" class="btn ">Previous sales Form</button>
                   <button type="button" class="btn" data-dismiss="modal">New sales Form</button>
               </div>
            </div>
            <input type="hidden" name="previous_form" id="previous_form">
        </form>
    </div>
</div>
