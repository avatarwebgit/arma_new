<div class="col-xl-4">
    <!--begin::مخلوط Widget 4-->
    <div class="card card-xl-stretch mb-xl-8">
        <!--begin::Beader-->
        <div class="card-header border-0 py-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">Online Market</span>
            </h3>
            <div class="card-toolbar">

            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        @if($market!=null)
        <div class="card-body d-flex flex-column">
            <div class="col-12">
                <h5 id="status-box-{{ $market->id }}" class="text-center">
                    Step : <span id="market-status-{{ $market->id }}"></span>
                </h5>

                <div class="clockk-wrap">
                    <div class="clockk pro-0">
                        <span id="market-difference1-{{ $market->id }}" class="d-flex timer-clock">

                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!--end::Body-->
    </div>
    <!--end::مخلوط Widget 4-->
</div>
