{{--  {{ dd($forms) }}  --}}
<nav class="dash-sidebar light-sidebar transprent-bg" style="background-color: {{ $side_bar_color }} !important;">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home.index') }}" class="b-brand text-center">
                <!-- ========   change your logo hear   ============ -->
                <img width="100" src="{{ imageExist(env('UPLOAD_SETTING'),$logo) }}"
                     class="app-logo img_setting"/>

            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar" style="display: block;">
                <li class="dash-item dash-hasmenu {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('seller.dashboard') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight">{{ __('Dashboard') }}</span></a>
                </li>
                @php
                    $pending_count=\App\Models\User::where('active_status',0)->count();
                @endphp
                <li class="">
                    <a href="{{ route('seller.profile') }}"
                       class="dash-link">
                            <span class="dash-micon">
                                <i class="fa fa-user"></i>
                            </span>
                        <span class="dash-mtext custom-weight">
                                {{ __('Profile') }}
                            </span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('sale_form',['page_type'=>'Create']) }}" class="dash-link">
                            <span class="dash-micon">
                                <i class="fa fa-pen"></i>
                            </span>
                        <span class="dash-mtext custom-weight">
                                Sales Order
                            </span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('seller.requests') }}" class="dash-link">
                            <span class="dash-micon">
                                <i class="fa fa-pen"></i>
                            </span>
                        <span class="dash-mtext custom-weight">
                                My Requests
                            </span>
                    </a>
                </li>

                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/users*') ? 'active dash-trigger' : 'collapsed' }}">

                    <a href="#!" class="dash-link position-relative">
                        <span class="dash-micon"><i
                                class="ti ti-layout-2"></i></span><span class="dash-mtext">{{ __('Wallet') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span>

                    </a>

                    <ul class="dash-submenu">
                        <li class="dash-item ">
                            <a href="{{ route('seller.wallet') }}"
                               class="dash-link">
                                <span class="dash-mtext custom-weight">
                                {{ __('Wallet') }}
                            </span>
                            </a>
                        </li>
                        <li class="dash-item ">
                            @php
                                $refund=\App\Models\Refund::where('user_id',auth()->id())->where('status','<',3)->get();
                            @endphp
                            <a href="{{ route('seller.refund_request') }}" class="dash-link">
                                <span class="dash-mtext custom-weight">
                                My Refund Request @if(count($refund)>0)
                                        <span class="circle_alert">{{ count($refund) }}</span>
                                    @endif
                            </span>
                            </a>
                        </li>
                    </ul>

                </li>
            </ul>
        </div>
    </div>
</nav>
