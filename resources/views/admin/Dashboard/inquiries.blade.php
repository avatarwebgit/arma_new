<div class="col-xl-4">
    <!--begin::مخلوط Widget 1-->
    <div class="card card-xl-stretch mb-xl-8">
        <!--begin::Body-->
        <div class="card-body p-0">
            <!--begin::Header-->
            <div class="px-9 pt-7 card-rounded h-275px w-100 bg-danger">
                <div class="d-flex text-center flex-column text-white pt-8">
{{--                            <span class="fw-semibold fs-7">--}}
{{--                                Inquiries--}}
{{--                            </span>--}}
                    <span class="fw-bold fs-2x pt-1">
                                Inquiries
                            </span>
                </div>
                <!--end::تعادل-->
            </div>

            <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1"
                 style="margin-top: -100px">
{{--                @can('Inquires-Inbox')--}}
                <div class="d-flex align-items-center mb-6">

                    <div class="d-flex align-items-center flex-wrap w-100">
                        <!--begin::Title-->
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('admin.sales_form.first.index', ['status' => 1]) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                {{ __('Inbox') }} ({{ $inquiryCounts['inbox'] }})
                            </a>
                        </div>
                        <!--end::Title-->
                        <!--begin::Tags-->
                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-inbox"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                        </div>
                        <!--end::Tags-->
                    </div>
                    <!--end::توضیحات-->
                </div>
{{--                @endcan--}}

                <div class="d-flex align-items-center mb-6">

                    <div class="d-flex align-items-center flex-wrap w-100">

                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('admin.sales_form.second.index', ['status' => 2]) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                {{ __('Offer Payment') }} ({{ $inquiryCounts['cash_pending'] }})
                            </a>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-money-bill-wave"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-down fs-5 text-danger ms-1"></i>
                        </div>

                    </div>

                </div>

                <div class="d-flex align-items-center mb-6">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <!--begin::Title-->
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="#" class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                {{ __('Data Pending') }} ({{ $inquiryCounts['data_pending'] }})
                            </a>
                            {{--                                    <div class="text-gray-500 fw-semibold fs-7">80% نرخ</div>--}}
                        </div>
                        <!--end::Title-->
                        <!--begin::Tags-->
                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-exclamation-triangle"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                        </div>
                        <!--end::Tags-->
                    </div>
                    <!--end::توضیحات-->
                </div>

                <div class="d-flex align-items-center mb-6">

                    <div class="d-flex align-items-center flex-wrap w-100">

                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('admin.sales_form.forth.index', ['status' => 4]) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                {{ __('Rejected') }} ({{ $inquiryCounts['rejected'] }})
                            </a>
                            {{--                                    <div class="text-gray-500 fw-semibold fs-7">بازپرداخت 3090</div>--}}
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-times-circle"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-down fs-5 text-danger ms-1"></i>
                        </div>

                    </div>
                </div>
                <div class="d-flex align-items-center mb-6">

                    <div class="d-flex align-items-center flex-wrap w-100">

                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('admin.sales_form.sixth.index', ['status' => 6]) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                {{ __('Preparation') }} ({{ $inquiryCounts['preparation'] }})
                            </a>
                            {{--                                    <div class="text-gray-500 fw-semibold fs-7">بازپرداخت 3090</div>--}}
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-hourglass-half"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-down fs-5 text-danger ms-1"></i>
                        </div>

                    </div>
                </div>

                <div class="d-flex align-items-center mb-6">
                    <div class="d-flex align-items-center flex-wrap w-100">

                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('admin.sales_form.fifth.index', ['status' => 5]) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                {{ __('Approved') }} ({{ $inquiryCounts['approved'] }})
                            </a>
                            {{--                                    <div class="text-gray-500 fw-semibold fs-7">بازپرداخت 3090</div>--}}
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-check-circle"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-down fs-5 text-danger ms-1"></i>
                        </div>

                    </div>
                </div>
            </div>


        </div>
        <!--end::Body-->
    </div>
    <!--end::مخلوط Widget 1-->
</div>
