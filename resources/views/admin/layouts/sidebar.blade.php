@php
    $role=auth()->user()->Roles[0]->name;
    if ($role=='admin' or $role=='Members'){
        $side_bar_color='#1400c6';
    }
        if ($role=='seller' or $role=='buyer'){
            $side_bar_color='black';
        }
        if ($role=='Representatives' or $role=='Brokers'){
            $side_bar_color='#7f74ff';
        }
@endphp

<nav class="dash-sidebar light-sidebar transprent-bg" style="background-color: {{ $side_bar_color }} !important;">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home.index') }}" class="b-brand text-center">
                <img width="100" src="{{ imageExist(env('UPLOAD_SETTING'), $logo) }}" class="app-logo img_setting"/>
            </a>
        </div>
        <div class="navbar-content">
            <div class="user-info dash-hasmenu">
                <a href="#!" class="dash-link position-relative">
                    <div class="d-flex flex-column align-items-center">
                        <div class="user-img mb-2">
                            <img src="{{ auth()->user()->avatar ?? asset('home/img/avatar.svg') }}"
                                 alt="{{ auth()->user()->name }}" class="rounded-circle" width="50">
                        </div>
                        <div class="user-details text-center">
                            <p class="email font-weight-bold mb-0">{{ auth()->user()->email }}</p>
                            <p class="name font-weight-bold mb-0">{{ auth()->user()->user_id }}</p>
                            <p class="role font-weight-normal mb-0">{{ auth()->user()->Roles()->first()->name ?? 'User' }}</p>
                        </div>
                    </div>
                </a>
            </div>

            <ul class="dash-navbar" style="display: block;">
                <li class="dash-item dash-hasmenu {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight">{{ __('Dashboard') }}</span>
                    </a>
                </li>

                <li class="dash-item">
                    <a href="#" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-user"></i></span>
                        <span class="dash-mtext">{{ __('My Profile') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="dash-submenu">
                        <li class="dash-item">
                            <a href="{{ route('admin.user.edit',['user'=>auth()->id()]) }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-settings"></i></span>
                                <span class="dash-mtext">{{ __('Account') }}</span>
                            </a>
                        </li>
                        <li class="dash-item">
                            <a href="{{ route('admin.user.edit',['user'=>auth()->id(),'type'=>'change_password']) }}"
                               class="dash-link">
                                <span class="dash-micon"><i class="ti ti-lock"></i></span>
                                <span class="dash-mtext">{{ __('Change Password') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @if($role=='seller')
                    @include('admin.layouts.seller_sidebar')
                @elseif($role=='buyer')
                    @include('admin.layouts.buyer_sidebar')
                @elseif($role=='Brokers' or $role=='Representatives')
                    @include('admin.layouts.broker_representatives')
                @elseif($role=='admin' or $role=='Members')
                    @include('admin.layouts.admin_member_sidebar')
                @endif
            </ul>
        </div>
    </div>
</nav>
