<div class="col-xl-4">
    <!--begin::مخلوط Widget 1-->
    <div class="card card-xl-stretch mb-xl-8">
        <!--begin::Body-->
        <div class="card-body p-0">
            <!--begin::Header-->
            <div class="px-9 pt-7 card-rounded h-275px w-100 bg-success">
                <div class="user-info dash-hasmenu">
                    <a href="#!" class="dash-link position-relative">
                        <div class="d-flex flex-column align-items-center">
                            <div class="user-img mb-2">
                                <img style="position: relative;z-index: 999" src="{{ imageExist(env('UPLOAD_IMAGE_PROFILE'), auth()->user()->image) }}"
                                     alt="{{ auth()->user()->name }}" class="rounded-circle" width="180">
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="bg-body shadow-sm card-rounded mx-9 mb-9 px-6 py-9 position-relative z-index-1"
                 style="margin-top: -100px">
                <div class="d-flex align-items-center mb-6">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('admin.user.edit',['user'=>auth()->id()]) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">Email</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                {{ auth()->user()->email }}
                            </div>
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-6">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('admin.user.edit',['user'=>auth()->id()]) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">Role</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                {{ ucfirst(auth()->user()->Roles()->first()->name) ?? 'User' }}
                            </div>
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-6">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('admin.user.edit',['user'=>auth()->id()]) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">Account</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-user"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-6">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('admin.user.edit',['user'=>auth()->id(),'type'=>'change_password']) }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">Change Password</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-lock"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-6">
                    <div class="d-flex align-items-center flex-wrap w-100">
                        <div class="mb-1 pe-3 flex-grow-1">
                            <a href="{{ route('logout') }}" class="fs-5 text-gray-800 text-hover-primary fw-bold">
                                logout
                            </a>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="fw-bold fs-5 text-gray-800 pe-1">
                                <span class="dash-micon"><i class="fas fa-sign-out"></i></span>
                            </div>
                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
