<div class="col-xl-4">
    <!--begin::مخلوط Widget 1-->
    <div class="card card-xl-stretch mb-xl-8">
        <!--begin::Body-->
        <div class="card-body p-0">
            <!--begin::Header-->
            <div class="px-9 pt-7 card-rounded h-275px w-100 bg-info">
                <div class="d-flex text-center flex-column text-white pt-8">
                    {{--                            <span class="fw-semibold fs-7">--}}
                    {{--                                Users--}}
                    {{--                            </span>--}}
                    <span class="fw-bold fs-2x pt-1">
                                 Sales Order
                            </span>
                </div>
            </div>
            <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1"
                 style="margin-top: -100px">
                <!--begin::item-->
                <div class="d-flex align-items-center mb-6">

                    <div class="d-flex align-items-center flex-wrap w-100">
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('sale_form', ['page_type' => 'Create']) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">New</a>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-file-alt"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                        </div>

                    </div>

                </div>

                <div class="d-flex align-items-center mb-6">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('sale_form_list',['type'=>'Save']) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                Save ( {{ $SalesFormCounts['Save'] }} )
                            </a>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-file-alt"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-down fs-5 text-danger ms-1"></i>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-6">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('sale_form_list',['type'=>'Draft']) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                Draft ( {{ $SalesFormCounts['Draft'] }} )
                            </a>
                            {{--                                    <div class="text-gray-500 fw-semibold fs-7">80% نرخ</div>--}}
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-file-alt"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>