<div class="modal fade" id="term_condition_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div style="max-width: 600px !important;" class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="term_form_modal" class="auth-form">
                <div class="modal-header position-relative" style="border-bottom: none !important;">
                    <i style="position: absolute;top:0;right: 0" data-dismiss="modal" aria-label="Close"
                       class="fa fa-times-circle fa-2x"></i>
                </div>
                <div class="modal-body">
                    @php
                    $page=\App\Models\Page::where('id',39)->first();
                    @endphp
                    @if($page)
                        {!! $page->description !!}
                    @endif

                </div>

                <div class="modal-footer">
                    <button data-dismiss="modal" aria-label="Close" style="background: white;color: black" type="button" class="btn btn-block">
                        Ok
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
