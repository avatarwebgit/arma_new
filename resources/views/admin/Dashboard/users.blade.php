<div class="col-xl-4">
    <!--begin::مخلوط Widget 1-->
    <div class="card card-xl-stretch mb-xl-8">
        <!--begin::Body-->
        <div class="card-body p-0">
            <!--begin::Header-->
            <div class="px-9 pt-7 card-rounded h-275px w-100 bg-primary">
                <div class="d-flex text-center flex-column text-white pt-8">
                    <span class="fw-bold fs-2x pt-1">
                                 Users
                            </span>
                </div>
            </div>
            <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1"
                 style="margin-top: -100px">
                @can('Users-Sellers')
                    <div class="d-flex align-items-center mb-6">

                        <div class="d-flex align-items-center flex-wrap w-100">

                            <div class="mb-1 pe-3 flex-grow-1">
                                <a href="{{ route('admin.users.seller.index', ['type' => 'seller']) }}"
                                   class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                    Sellers ({{ $roleCounts['sellers'] }})
                                </a>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="fw-bold fs-5 text-gray-800 pe-1">
                                    <span class="dash-micon"><i class="fas fa-shopping-cart"></i></span>
                                </div>
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                            </div>
                            <!--end::Tags-->
                        </div>
                        <!--end::توضیحات-->
                    </div>
                @endcan
                @can('Users-Buyers')
                    <div class="d-flex align-items-center mb-6">
                        <div class="d-flex align-items-center flex-wrap w-100">
                            <!--begin::Title-->
                            <div class="mb-1 pe-3 flex-grow-1">
                                <a href="{{ route('admin.users.buyer.index', ['type' => 'buyer']) }}"
                                   class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                    Buyers ({{ $roleCounts['buyers'] }})
                                </a>
                            </div>
                            <!--end::Title-->
                            <!--begin::Tags-->
                            <div class="d-flex align-items-center">
                                <div class="fw-bold fs-5 text-gray-800 pe-1">
                                    <span class="dash-micon"><i class="fas fa-shopping-basket"></i></span>
                                </div>
                                <i class="ki-outline ki-arrow-down fs-5 text-danger ms-1"></i>
                            </div>
                            <!--end::Tags-->
                        </div>
                        <!--end::توضیحات-->
                    </div>
                @endcan
                @can('Users-Brokers')
                    <div class="d-flex align-items-center mb-6">
                        <div class="d-flex align-items-center flex-wrap w-100">
                            <div class="mb-1 pe-3 flex-grow-1">
                                <a href="{{ route('admin.users.brokers.index', ['type' => 'Brokers']) }}"
                                   class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                    Brokers ({{ $roleCounts['brokers'] }})
                                </a>
                                {{--                                    <div class="text-gray-500 fw-semibold fs-7">80% نرخ</div>--}}
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="fw-bold fs-5 text-gray-800 pe-1">
                                    <span class="dash-micon"><i class="fas fa-briefcase"></i></span>
                                </div>
                                <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('Users-Members')
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center flex-wrap w-100">
                            <div class="mb-1 pe-3 flex-grow-1">
                                <a href="{{ route('admin.users.members.index', ['type' => 'Members']) }}"
                                   class="fs-5 text-gray-800 text-hover-primary fw-bold"> Members
                                    ({{ $roleCounts['members'] }})</a>
                                {{--                                    <div class="text-gray-500 fw-semibold fs-7">بازپرداخت 3090</div>--}}
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="fw-bold fs-5 text-gray-800 pe-1">
                                    <span class="dash-micon"><i class="fas fa-user"></i></span>
                                </div>
                                <i class="ki-outline ki-arrow-down fs-5 text-danger ms-1"></i>
                            </div>

                        </div>

                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>
