<div class="col-xl-8">
    <!--begin::مخلوط Widget 1-->
    <div class="card card-xl-stretch mb-xl-8">
        <!--begin::Body-->
        <div class="card-body p-0">
            <!--begin::Header-->
            <div class="px-9 pt-7 card-rounded h-275px w-100 bg-warning" style="background: #1400c6 !important;">
                <div class="d-flex text-center flex-column text-white pt-8">
                    {{--                            <span class="fw-semibold fs-7">--}}
                    {{--                                Users--}}
                    {{--                            </span>--}}
                    <span class="fw-bold fs-2x pt-1 text-white">
                                 Market
                            </span>
                </div>
                <div class="d-flex justify-content-between">
                    <button onclick="createMarketModal()" class="btn btn-primary btn-sm">
                        Create
                    </button>
                    <a href="{{ route('admin.markets.settings') }}" class="btn btn-success">
                        <span class="dash-micon"><i class="fas fa-cog"></i></span>
                         Setting
                    </a>
                </div>
            </div>
            <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1"
                 style="margin-top: -100px">

                <div class="d-flex align-items-center mb-6">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        @include('admin.markets.table')
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>
