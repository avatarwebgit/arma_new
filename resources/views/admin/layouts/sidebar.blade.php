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
                    <a href="{{ route('admin.dashboard') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight">{{ __('Dashboard') }}</span></a>
                </li>
                @php
                    $registering_count=\App\Models\User::where('active_status',1)->count();
                    $index_count=\App\Models\User::where('active_status',0)->count();
                    $rejected_count=\App\Models\User::where('active_status',3)->count();
                    $users_confirmed=\App\Models\User::where('active_status',2)->get();
                    $user_ids=[];
                    $confirmed_count=0;
            foreach ($users_confirmed as $key => $user) {
                $role_count = $user->Roles()->count();
                if ($role_count > 0) {
                    $users_confirmed->forget($key);
                    continue;
                }
                $user_ids[] = $user->id;
                $confirmed_count = \App\Models\User::WhereIn('id', $user_ids)->count();
            }
                    $users_seller = \App\Models\User::where('active_status', 2)->where('active',1)->get();
                    $seller_ids = [];
                    foreach ($users_seller as $user_seller) {
                        if ($user_seller->hasRole('seller')) {
                            $seller_ids[] = $user_seller->id;
                        }
                    }
                    $users_seller_count = \App\Models\User::whereIn('id', $seller_ids)->count();

                    $users_buyer = \App\Models\User::where('active_status', 2)->get();
                    $buyer_ids = [];
                    foreach ($users_buyer as $user_buyer) {
                        if ($user_buyer->hasRole('buyer')) {
                            $buyer_ids[] = $user_buyer->id;
                        }
                    }
                    $users_buyer_count = \App\Models\User::whereIn('id', $buyer_ids)->where('active',1)->get();

                    $users_member = \App\Models\User::where('active_status', 2)->get();
                    $member_ids = [];
                    foreach ($users_member as $user_member) {
                        if ($user_member->hasRole('Members')) {
                            $member_ids[] = $user_member->id;
                        }
                    }
                    $users_member_count = \App\Models\User::whereIn('id', $member_ids)->get();

                    $users_Representative = \App\Models\User::where('active_status', 2)->get();
                    $Representative_ids = [];
                    foreach ($users_Representative as $user_Representative) {
                        if ($user_Representative->hasRole('Representatives')) {
                            $Representative_ids[] = $user_Representative->id;
                        }
                    }
                    $users_Representative_count = \App\Models\User::whereIn('id', $Representative_ids)->get();

                    $users_Brokers = \App\Models\User::where('active_status', 2)->where('active',1)->get();
                    $Brokers_ids = [];
                    foreach ($users_Brokers as $user_Brokers) {
                        if ($user_Brokers->hasRole('Brokers')) {
                            $Brokers_ids[] = $user_Brokers->id;
                        }
                    }
                    $users_Brokers_count = \App\Models\User::whereIn('id', $Brokers_ids)->get();

                    $users_suspended = \App\Models\User::where('active_status', 2)->where('active',2)->get();
                    $users_blocked = \App\Models\User::where('active_status', 2)->where('active',3)->get();


                @endphp

                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/users*') ? 'active dash-trigger' : 'collapsed' }}">

                    <a href="#!" class="dash-link position-relative"><span class="dash-micon"><i
                                class="ti ti-layout-2"></i></span><span
                            class="dash-mtext">{{ __('Users') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span>
                        {{--                        @if($pending_count>0)--}}
                        {{--                            <span--}}
                        {{--                                class="circle-notification circle-notification-absolute">{{ $pending_count }}</span>--}}
                        {{--                        @endif--}}
                    </a>

                    <ul class="dash-submenu">
                        @can('Users-Inbox')
                            <li class="dash-item {{ request()->is('users/1*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.users.zero.index',['type'=>0]) }}">
                                    Inbox ({{ $index_count }})
                                </a>
                            </li>
                        @endcan

                        @can('Users-Registering')
                            <li class="dash-item d-flex align-items-center {{ request()->is('users*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.users.first.index',['type'=>1]) }}">Registering
                                    ({{ $registering_count }}
                                    )</a>
                            </li>
                        @endcan

                        @can('Users-Rejected')
                            <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.users.third.index',['type'=>3]) }}">
                                    Rejected ({{ $rejected_count }})
                                </a>
                            </li>
                        @endcan

                        @can('Users-Confirmed')
                            <li class="dash-item">
                                <a class="dash-link"
                                   href="{{ route('admin.users.second.index',['type'=>2]) }}">
                                    Confirmed ({{ $confirmed_count }})
                                </a>
                            </li>
                        @endcan

                        @can('Users-Sellers')
                            <li class="dash-item">
                                <a class="dash-link"
                                   href="{{ route('admin.users.seller.index',['type'=>'seller']) }}">
                                    Sellers ({{ $users_seller_count }})
                                </a>
                            </li>
                        @endcan

                        @can('Users-Buyers')
                            <li class="dash-item">
                                <a class="dash-link"
                                   href="{{ route('admin.users.buyer.index',['type'=>'buyer']) }}">
                                    Buyers ({{ count($users_buyer_count) }})
                                </a>
                            </li>
                        @endcan

                        @can('Users-Brokers')
                            <li class="dash-item">
                                <a class="dash-link"
                                   href="{{ route('admin.users.brokers.index',['type'=>'Brokers']) }}">
                                    Brokers ({{ count($users_Brokers_count) }})
                                </a>
                            </li>
                        @endcan


                        @can('Users-Members')
                            <li class="dash-item">
                                <a class="dash-link"
                                   href="{{ route('admin.users.members.index',['type'=>'Members']) }}">
                                    Members ({{ count($users_member_count) }})
                                </a>
                            </li>
                        @endcan

                        @can('Users-Representatives')
                            <li class="dash-item">
                                <a class="dash-link"
                                   href="{{ route('admin.users.Representatives.index',['type'=>'Representatives']) }}">
                                    Representatives ({{ count($users_Representative_count) }})
                                </a>
                            </li>
                        @endcan
                        <li class="dash-item">
                            <a class="dash-link"
                               href="{{ route('admin.users.status',['status'=>2]) }}">
                                Suspend({{ count($users_suspended) }})
                            </a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link"
                               href="{{ route('admin.users.status',['status'=>3]) }}">
                                Blocked ({{ count($users_blocked) }})
                            </a>
                        </li>


                        {{--                        @can('roles')--}}
                        {{--                            <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">--}}
                        {{--                                <a class="dash-link" href="{{ route('admin.roles.index') }}">{{ __('Roles') }}</a>--}}
                        {{--                            </li>--}}
                        {{--                        @endcan--}}
                        {{--                        @can('permissions')--}}
                        {{--                            <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">--}}
                        {{--                                <a class="dash-link"--}}
                        {{--                                   href="{{ route('admin.permission.index') }}">{{ __('Permissions') }}</a>--}}
                        {{--                            </li>--}}
                        {{--                        @endcan--}}
                    </ul>

                </li>
                @php
                    $inbox_count=\App\Models\SalesOfferForm::where('status',1)->where('used_in_market',0)->count();
                    $cash_pending_count=\App\Models\SalesOfferForm::where('status',2)->where('used_in_market',0)->count();
                    $data_pending_count=\App\Models\SalesOfferForm::where('status',3)->where('used_in_market',0)->count();
                    $reject_count=\App\Models\SalesOfferForm::where('status',4)->where('used_in_market',0)->count();
                    $approved_count=\App\Models\SalesOfferForm::where('status',5)->where('used_in_market',0)->count();
                    $preparation_count=\App\Models\SalesOfferForm::where('status',6)->where('used_in_market',0)->count();
                @endphp

                <li class="dash-item">
                    <a href="#!" class="dash-link position-relative">
                                <span class="dash-micon">
                                <i class="ti ti-table"></i>
                            </span>

                        <span
                            class="dash-mtext custom-weight">{{ __('Inquiries') }}</span><span
                            class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        {{--                        @if($pending_count>0)--}}
                        {{--                            <span--}}
                        {{--                                class="circle-notification circle-notification-absolute">{{ $pending_count }}</span>--}}
                        {{--                        @endif--}}
                    </a>

                    @php
                        $need_to_confirm_count=\App\Models\FormValue::where('status',3)->count();
                    @endphp
                    <ul class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
                        @can('Inquires-Inbox')
                            <li class="dash-item d-flex align-items-center">
                                <a href="{{ route('admin.sales_form.first.index',['status'=>1]) }}"
                                   class="dash-link"><span
                                        class="dash-mtext custom-weight">{{ __('Inbox').'('.$inbox_count.')' }}
                                </a>
                            </li>
                        @endcan

                        @can('Inquires-Cash-Pending')
                            <li class="dash-item d-flex align-items-center">
                                <a href="{{ route('admin.sales_form.second.index',['status'=>2]) }}"
                                   class="dash-link"><span
                                        class="dash-mtext custom-weight">{{ __('Offer Payment').'('.$cash_pending_count.')' }}
                                </a>
                            </li>
                        @endcan

                        @can('Inquires-Data-Pending')
                            <li class="dash-item d-flex align-items-center">
                                <a href="{{ route('admin.sales_form.third.index',['status'=>3]) }}"
                                   class="dash-link"><span
                                        class="dash-mtext custom-weight">{{ __('Data Pending').'('.$data_pending_count.')' }}
                                </a>
                            </li>
                        @endcan
                        @can('Inquires-Rejected-Inquiries')
                            <li class="dash-item d-flex align-items-center">
                                <a href="{{ route('admin.sales_form.forth.index',['status'=>4]) }}"
                                   class="dash-link"><span
                                        class="dash-mtext custom-weight">{{ __('Rejected').'('.$reject_count.')' }}
                                </a>
                            </li>
                        @endcan
                        @can('Inquires-Preparation')
                            <li class="dash-item d-flex align-items-center">
                                <a href="{{ route('admin.sales_form.sixth.index',['status'=>6]) }}"
                                   class="dash-link"><span
                                        class="dash-mtext custom-weight">{{ __('Preparation').'('.$preparation_count.')' }}
                                </a>
                            </li>
                        @endcan
                        @can('Inquires-Approved')
                            <li class="dash-item d-flex align-items-center">
                                <a href="{{ route('admin.sales_form.fifth.index',['status'=>5]) }}"
                                   class="dash-link"><span
                                        class="dash-mtext custom-weight">{{ __('Approved').'('.$approved_count.')' }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @php
                    $market_count=\App\Models\Market::all()->groupBy('date')->count();
                @endphp

                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/markets*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="#!" class="dash-link">
                            <span class="dash-micon">
                <i class="ti ti-table"></i></span><span
                            class="dash-mtext">{{ __('Markets') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
{{--                        @can('Market-Create-Market')--}}
{{--                            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">--}}
{{--                                <a class="dash-link"--}}
{{--                                   onclick="createMarketModal()">Create Market</a>--}}
{{--                            </li>--}}
{{--                        @endcan--}}

                        @can('Market-Markets')
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.markets.index') }}">Markets ({{ $market_count }})</a>
                            </li>
                        @endcan

                        @can('Market-Setting')
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.markets.settings') }}">{{ __('Market Setting') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>

                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/markets*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="#!" class="dash-link">
                            <span class="dash-micon">
                <i class="ti ti-table"></i></span><span
                            class="dash-mtext">{{ __('Sales Order') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        @can('Sales-Order-Sales-Offer-form')
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('sale_form',['page_type'=>'Create']) }}">Sales Offer
                                    Form</a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @can('Bid-Deposit-Refund-Request')
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/markets*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon">
                <i class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Bid Deposit') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            @php
                                $refund=\App\Models\Refund::where('status','<',3)->get();
                            @endphp
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.refund_request') }}">
                                    Refund Request @if(count($refund)>0)
                                        <span class="circle_alert">{{ count($refund) }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('Line-1')

                    <li class="dash-item dash-hasmenu">
                        <a href="{{ route('admin.header1.index') }}" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-home"></i></span>
                            <span class="dash-mtext custom-weight">
                            Line 1
                        </span></a>
                    </li>
                @endcan

                @can('Line-2')
                    <li class="dash-item dash-hasmenu {{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ route('admin.header2.index') }}" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-home"></i></span>
                            <span class="dash-mtext custom-weight">
                            Line 2
                        </span></a>
                    </li>
                @endcan

                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/settings*') ? 'active' : '' }}">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-apps"></i></span><span
                            class="dash-mtext">{{ __('Settings') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">

                        @can('Settings-Setting')
                            <li class="dash-item {{ request()->is('admin-panel/management/settings*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.settings.index') }}">{{ __('Setting') }}</a>
                            </li>
                        @endcan
                        @can('Settings-Currency')
                            <li class="dash-item {{ request()->is('admin-panel/management/settings/currenc*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.currencies.index') }}">{{ __('Currency') }}</a>
                            </li>
                        @endcan

                    </ul>
                </li>

                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-apps"></i></span><span
                            class="dash-mtext">{{ __('Page builder') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <li class="dash-item ">
                            <a class="dash-link" href="{{ route('admin.menus.index') }}">{{ __('Menus') }}</a>
                        </li>
                        <li class="dash-item ">
                            <a class="dash-link" href="{{ route('admin.pages.index') }}">{{ __('Pages') }}</a>
                        </li>
                    </ul>
                </li>

                @can('Message')
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/messages*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Message') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/emails*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.emails.index') }}">{{ __('Email') }}</a>
                            </li>
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/alerts*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.alerts.index') }}">{{ __('Alert') }}</a>
                            </li>

                        </ul>
                    </li>
                @endcan

                @can('Contact-Message')
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/form-contact*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="{{route('admin.contact.index')}}" class="dash-link">
                           <span class="dash-micon">
                <i class="ti ti-table"></i></span>
                            <span
                                class="dash-mtext">{{ __('Contact Message') }}</span>
                        </a>

                    </li>
                @endcan


                @can('Blog')
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/blog*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon">
                <i class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Blogs') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/blogs*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.blog.index') }}">{{ __('Blog') }}</a>
                            </li>
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/category*') ? 'active' : '' }}">
                                <a class="dash-link"
                                   href="{{ route('admin.blog.category.index') }}">{{ __('Category') }}</a>
                            </li>
                        </ul>
                    </li>
                @endcan

            </ul>
        </div>
    </div>
</nav>

