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
                    $confirmed_count=\App\Models\User::where('active_status',2)->count();
                    $rejected_count=\App\Models\User::where('active_status',3)->count();
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
                        <li class="dash-item {{ request()->is('users/1*') ? 'active' : '' }}">
                            <a class="dash-link"
                               href="{{ route('admin.users.index',['type'=>0]) }}">
                                Index ({{ $index_count }})
                            </a>
                        </li>
                        <li class="dash-item d-flex align-items-center {{ request()->is('users*') ? 'active' : '' }}">
                            <a class="dash-link"
                               href="{{ route('admin.users.index',['type'=>1]) }}">Registering ({{ $registering_count }}
                                )</a>
                        </li>
                        <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                            <a class="dash-link"
                               href="{{ route('admin.users.index',['type'=>3]) }}">
                                Rejected Users ({{ $rejected_count }})
                            </a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link"
                               href="{{ route('admin.users.index',['type'=>2]) }}">
                                Confirmed ({{ $confirmed_count }})
                            </a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link"
                               href="">
                                Sellers (0)
                            </a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link"
                               href="">
                                Buyers (0)
                            </a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link"
                               href="">
                                Members (0)
                            </a>
                        </li>

                        <li class="dash-item">
                            <a class="dash-link"
                               href="">
                                Representatives (0)
                            </a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link" href="">
                                Brokers (0)
                            </a>
                        </li>

                        <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('admin.roles.index') }}">{{ __('Roles') }}</a>
                        </li>
                        <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">
                            <a class="dash-link"
                               href="{{ route('admin.permission.index') }}">{{ __('Permissions') }}</a>
                        </li>
                    </ul>

                </li>
                @php
                    $inbox_count=\App\Models\SalesOfferForm::where('status',1)->count();
                    $cash_pending_count=\App\Models\SalesOfferForm::where('status',2)->count();
                    $data_pending_count=\App\Models\SalesOfferForm::where('status',3)->count();
                    $reject_count=\App\Models\SalesOfferForm::where('status',4)->count();
                    $approved_count=\App\Models\SalesOfferForm::where('status',5)->count();
                    $preparation_count=\App\Models\SalesOfferForm::where('status',6)->count();
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
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>1]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Inbox').'('.$inbox_count.')' }}
                            </a>
                        </li>
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>2]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Cash Pending').'('.$cash_pending_count.')' }}
                            </a>
                        </li>
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>3]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Data Pending').'('.$data_pending_count.')' }}
                            </a>
                        </li>
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>4]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Rejected Inquiries').'('.$reject_count.')' }}
                            </a>
                        </li>
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>6]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Preparation').'('.$preparation_count.')' }}
                            </a>
                        </li>
                        <li class="dash-item d-flex align-items-center">
                            <a href="{{ route('admin.sales_form.index',['status'=>5]) }}" class="dash-link"><span
                                    class="dash-mtext custom-weight">{{ __('Approved').'('.$approved_count.')' }}
                            </a>
                        </li>
                    </ul>
                </li>

                @php
                    $market_count=\App\Models\Market::all()->count();
                @endphp

                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/markets*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="#!" class="dash-link">
                            <span class="dash-micon">
                <i class="ti ti-table"></i></span><span
                            class="dash-mtext">{{ __('Markets') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">
                            <a class="dash-link"
                               onclick="createMarketModal()">Create Market</a>
                        </li>
                        <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">
                            <a class="dash-link"
                               href="{{ route('admin.markets.index') }}">Markets ({{ $market_count }})</a>
                        </li>
                        <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">
                            <a class="dash-link"
                               href="{{ route('admin.markets.settings') }}">{{ __('Market Setting') }}</a>
                        </li>
                    </ul>
                </li>

                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/markets*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="#!" class="dash-link">
                            <span class="dash-micon">
                <i class="ti ti-table"></i></span><span
                            class="dash-mtext">{{ __('Sales Order') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">
                        <li class="dash-item {{ request()->is('admin-panel/management/messages/markets*') ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('sale_form',['page_type'=>'Create']) }}">Sales Offer
                                Form</a>
                        </li>
                    </ul>
                </li>
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
                <li class="dash-item dash-hasmenu">
                    <a href="{{ route('admin.header1.index') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight">
                            Line 1
                        </span></a>
                </li>
                <li class="dash-item dash-hasmenu {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('admin.header2.index') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight">
                            Line 2
                        </span></a>
                </li>


                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/settings*') ? 'active' : '' }}">
                    <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-apps"></i></span><span
                            class="dash-mtext">{{ __('Settings') }}</span><span class="dash-arrow"><i
                                data-feather="chevron-right"></i></span></a>
                    <ul class="dash-submenu">


                        <li class="dash-item {{ request()->is('admin-panel/management/settings*') ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('admin.settings.index') }}">{{ __('Setting') }}</a>
                        </li>

                        <li class="dash-item {{ request()->is('admin-panel/management/settings/currenc*') ? 'active' : '' }}">
                            <a class="dash-link" href="{{ route('admin.currencies.index') }}">{{ __('Currency') }}</a>
                        </li>

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
                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/form-contact*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="{{route('admin.contact.index')}}" class="dash-link">
                           <span class="dash-micon">
                <i class="ti ti-table"></i></span>
                        <span
                            class="dash-mtext">{{ __('Contact Message') }}</span>
                    </a>

                </li>


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

            </ul>
        </div>
    </div>
</nav>

