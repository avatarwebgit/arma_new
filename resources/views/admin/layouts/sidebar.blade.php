@php
$role=auth()->user()->Roles[0]->name;
if ($role=='admin' or $role=='Members'){
    $side_bar_color='#1400c6';
}
    if ($role=='seller'){
        $side_bar_color='black';
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
                            <img src="{{ auth()->user()->avatar ?? asset('home/img/avatar.svg') }}" alt="{{ auth()->user()->name }}" class="rounded-circle" width="50">
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
                            <a href="{{ route('admin.user.edit',['user'=>auth()->id(),'type'=>'change_password']) }}" class="dash-link">
                                <span class="dash-micon"><i class="ti ti-lock"></i></span>
                                <span class="dash-mtext">{{ __('Change Password') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>

                @if($role=='seller')
                    <!-- Sales Order Section -->
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/orders*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-package"></i></span>
                            <span class="dash-mtext">{{ __('Sales Order') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">

                                <li class="dash-item">
                                    <a class="dash-link" href="{{ route('sale_form', ['page_type' => 'Create']) }}">
                                        <span class="dash-micon"><i class="ti ti-file"></i></span>
                                        Sales Offer Form
                                    </a>
                                </li>
                        </ul>
                    </li>
                    <!-- Sales Order Section -->
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-package"></i></span>
                            <span class="dash-mtext">{{ __('Transactions') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                                <li class="dash-item">

                                </li>
                        </ul>
                    </li>
                    <!-- Sales Order Section -->
                    <li class="dash-item dash-hasmenu">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-package"></i></span>
                            <span class="dash-mtext">{{ __('Messages') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            <li class="dash-item">

                            </li>
                        </ul>
                    </li>

                @elseif($role=='admin' or $role=='Members')



                @php
                    // Counts for Users
                    $userCounts = [
                        'registering' => \App\Models\User::where('active_status', 1)->count(),
                        'index' => \App\Models\User::where('active_status', 0)->count(),
                        'rejected' => \App\Models\User::where('active_status', 3)->count(),
                        'confirmed' => \App\Models\User::where('active_status', 2)->whereDoesntHave('roles')->count(),
                        'suspended' => \App\Models\User::where('active_status', 2)->where('active', 2)->count(),
                        'blocked' => \App\Models\User::where('active_status', 2)->where('active', 3)->count(),
                    ];

                    // Counts for specific roles
                    $roleCounts = [
                        'sellers' => \App\Models\User::where('active_status', 2)->where('active', 1)->whereHas('roles', function ($query) {
                            $query->where('name', 'seller');
                        })->count(),
                        'buyers' => \App\Models\User::where('active_status', 2)->where('active', 1)->whereHas('roles', function ($query) {
                            $query->where('name', 'buyer');
                        })->count(),
                        'members' => \App\Models\User::where('active_status', 2)->where('active', 1)->whereHas('roles', function ($query) {
                            $query->where('name', 'Members');
                        })->count(),
                        'representatives' => \App\Models\User::where('active_status', 2)->where('active', 1)->whereHas('roles', function ($query) {
                            $query->where('name', 'Representatives');
                        })->count(),
                        'brokers' => \App\Models\User::where('active_status', 2)->where('active', 1)->whereHas('roles', function ($query) {
                            $query->where('name', 'Brokers');
                        })->count(),
                    ];
                @endphp

                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/users*') ? 'active dash-trigger' : '' }}">
                    <a href="#!" class="dash-link position-relative">
                        <span class="dash-micon"><i class="ti ti-layout-2"></i></span>
                        <span class="dash-mtext">{{ __('Users') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="dash-submenu">
                        @can('Users-Inbox')
                            <li class="dash-item {{ request()->is('users/1*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.users.zero.index', ['type' => 0]) }}">
                                    <span class="dash-micon"><i class="ti ti-inbox"></i></span>
                                    Inbox ({{ $userCounts['index'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Users-Registering')
                            <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.users.first.index', ['type' => 1]) }}">
                                    <span class="dash-micon"><i class="ti ti-user-add"></i></span>
                                    Registering ({{ $userCounts['registering'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Users-Rejected')
                            <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.users.third.index', ['type' => 3]) }}">
                                    <span class="dash-micon"><i class="ti ti-user-delete"></i></span>
                                    Rejected ({{ $userCounts['rejected'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Users-Confirmed')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.users.second.index', ['type' => 2]) }}">
                                    <span class="dash-micon"><i class="ti ti-check"></i></span>
                                    Confirmed ({{ $userCounts['confirmed'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Users-Sellers')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.users.seller.index', ['type' => 'seller']) }}">
                                    <span class="dash-micon"><i class="ti ti-shopping-cart"></i></span>
                                    Sellers ({{ $roleCounts['sellers'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Users-Buyers')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.users.buyer.index', ['type' => 'buyer']) }}">
                                    <span class="dash-micon"><i class="ti ti-basket"></i></span>
                                    Buyers ({{ $roleCounts['buyers'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Users-Brokers')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.users.brokers.index', ['type' => 'Brokers']) }}">
                                    <span class="dash-micon"><i class="ti ti-briefcase"></i></span>
                                    Brokers ({{ $roleCounts['brokers'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Users-Members')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.users.members.index', ['type' => 'Members']) }}">
                                    <span class="dash-micon"><i class="ti ti-user"></i></span>
                                    Members ({{ $roleCounts['members'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Users-Representatives')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.users.Representatives.index', ['type' => 'Representatives']) }}">
                                    <span class="dash-micon"><i class="ti ti-user-check"></i></span>
                                    Representatives ({{ $roleCounts['representatives'] }})
                                </a>
                            </li>
                        @endcan
                        <li class="dash-item">
                            <a class="dash-link" href="{{ route('admin.users.status', ['status' => 2]) }}">
                                <span class="dash-micon"><i class="ti ti-user-off"></i></span>
                                Suspended ({{ $userCounts['suspended'] }})
                            </a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link" href="{{ route('admin.users.status', ['status' => 3]) }}">
                                <span class="dash-micon"><i class="ti ti-lock"></i></span>
                                Blocked ({{ $userCounts['blocked'] }})
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Inquiries Section -->
                @php
                    $inquiryCounts = [
                        'inbox' => \App\Models\SalesOfferForm::where('status', 1)->whereNotNull('form_id')->where('used_in_market', 0)->count(),
                        'cash_pending' => \App\Models\SalesOfferForm::where('status', 2)->where('used_in_market', 0)->count(),
                        'data_pending' => \App\Models\SalesOfferForm::where('status', 3)->where('used_in_market', 0)->count(),
                        'rejected' => \App\Models\SalesOfferForm::where('status', 4)->where('used_in_market', 0)->count(),
                        'approved' => \App\Models\SalesOfferForm::where('status', 5)->where('used_in_market', 0)->count(),
                        'preparation' => \App\Models\SalesOfferForm::where('status', 6)->where('used_in_market', 0)->count(),
                    ];
                @endphp

                <li class="dash-item">
                    <a href="#!" class="dash-link position-relative">
                        <span class="dash-micon"><i class="ti ti-clipboard"></i></span>
                        <span class="dash-mtext custom-weight">{{ __('Inquiries') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
                        @can('Inquires-Inbox')
                            <li class="dash-item">
                                <a href="{{ route('admin.sales_form.first.index', ['status' => 1]) }}" class="dash-link">
                                    <span class="dash-micon"><i class="ti ti-inbox"></i></span>
                                    {{ __('Inbox') }} ({{ $inquiryCounts['inbox'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Inquires-Cash-Pending')
                            <li class="dash-item">
                                <a href="{{ route('admin.sales_form.second.index', ['status' => 2]) }}" class="dash-link">
                                    <span class="dash-micon"><i class="ti ti-money"></i></span>
                                    {{ __('Offer Payment') }} ({{ $inquiryCounts['cash_pending'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Inquires-Data-Pending')
                            <li class="dash-item">
                                <a href="{{ route('admin.sales_form.third.index', ['status' => 3]) }}" class="dash-link">
                                    <span class="dash-micon"><i class="ti ti-alert"></i></span>
                                    {{ __('Data Pending') }} ({{ $inquiryCounts['data_pending'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Inquires-Rejected-Inquiries')
                            <li class="dash-item">
                                <a href="{{ route('admin.sales_form.forth.index', ['status' => 4]) }}" class="dash-link">
                                    <span class="dash-micon"><i class="ti ti-x"></i></span>
                                    {{ __('Rejected') }} ({{ $inquiryCounts['rejected'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Inquires-Preparation')
                            <li class="dash-item">
                                <a href="{{ route('admin.sales_form.sixth.index', ['status' => 6]) }}" class="dash-link">
                                    <span class="dash-micon"><i class="ti ti-time"></i></span>
                                    {{ __('Preparation') }} ({{ $inquiryCounts['preparation'] }})
                                </a>
                            </li>
                        @endcan
                        @can('Inquires-Approved')
                            <li class="dash-item">
                                <a href="{{ route('admin.sales_form.fifth.index', ['status' => 5]) }}" class="dash-link">
                                    <span class="dash-micon"><i class="ti ti-check"></i></span>
                                    {{ __('Approved') }} ({{ $inquiryCounts['approved'] }})
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                <!-- Markets Section -->
                @php
                    $market_count = \App\Models\Market::all()->groupBy('date')->count();
                @endphp

                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/markets*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-market"></i></span>
                        <span class="dash-mtext">{{ __('Markets') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="dash-submenu">
                        @can('Market-Markets')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.markets.index') }}">
                                    <span class="dash-micon"><i class="ti ti-list"></i></span>
                                    Markets ({{ $market_count }})
                                </a>
                            </li>
                        @endcan
                        @can('Market-Setting')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.markets.settings') }}">
                                    <span class="dash-micon"><i class="ti ti-settings"></i></span>
                                    {{ __('Market Setting') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                <!-- Sales Order Section -->
                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/orders*') ? 'active dash-trigger' : 'collapsed' }}">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-package"></i></span>
                        <span class="dash-mtext">{{ __('Sales Order') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="dash-submenu">
                        @can('Sales-Order-Sales-Offer-form')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('sale_form', ['page_type' => 'Create']) }}">
                                    <span class="dash-micon"><i class="ti ti-file"></i></span>
                                    Sales Offer Form
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                <!-- Bid Deposit Section -->
                @can('Bid-Deposit-Refund-Request')
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/bid*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-money"></i></span>
                            <span class="dash-mtext">{{ __('Bid Deposit') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            @php
                                $refund = \App\Models\Refund::where('status', '<', 3)->count();
                            @endphp
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.refund_request') }}">
                                    <span class="dash-micon"><i class="ti ti-reload"></i></span>
                                    Refund Request @if($refund > 0) <span class="circle_alert">{{ $refund }}</span> @endif
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                <!-- Lines Section -->
                @can('Line-1')
                    <li class="dash-item">
                        <a href="{{ route('admin.header1.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-header"></i></span>
                            <span class="dash-mtext custom-weight">{{ __('Line |') }}</span>
                        </a>
                    </li>
                @endcan

                @can('Line-2')
                    <li class="dash-item">
                        <a href="{{ route('admin.header2.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-header"></i></span>
                            <span class="dash-mtext custom-weight">{{ __('Line ||') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- Settings Section -->
                <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/settings*') ? 'active' : '' }}">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-apps"></i></span>
                        <span class="dash-mtext">{{ __('Settings') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="dash-submenu">
                        @can('Settings-Setting')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.settings.index',['type'=>'header']) }}">
                                    <span class="dash-micon"><i class="ti ti-settings"></i></span>
                                    {{ __('Header') }}
                                </a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.settings.index',['type'=>'footer']) }}">
                                    <span class="dash-micon"><i class="ti ti-settings"></i></span>
                                    {{ __('Footer') }}
                                </a>
                            </li>
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.settings.index',['type'=>'general']) }}">
                                    <span class="dash-micon"><i class="ti ti-settings"></i></span>
                                    {{ __('General') }}
                                </a>
                            </li>
                        @endcan
                        @can('Settings-Currency')
                            <li class="dash-item">
                                <a class="dash-link" href="{{ route('admin.currencies.index') }}">
                                    <span class="dash-micon"><i class="ti ti-money"></i></span>
                                    {{ __('Currency') }}
                                </a>
                            </li>
                        @endcan

                        <li class="dash-item">
                            <a class="dash-link" href="{{ route('admin.countries.index') }}">
                                <span class="dash-micon"><i class="ti ti-money"></i></span>
                                {{ __('Country') }}
                            </a>
                        </li>

                        <li class="dash-item">
                            <a class="dash-link" href="{{ route('admin.packages.index') }}">
                                <span class="dash-micon"><i class="ti ti-money"></i></span>
                                {{ __('Package') }}
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- Page Builder Section -->
                <li class="dash-item dash-hasmenu">
                    <a href="#!" class="dash-link">
                        <span class="dash-micon"><i class="ti ti-layout"></i></span>
                        <span class="dash-mtext">{{ __('Page builder') }}</span>
                        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                    </a>
                    <ul class="dash-submenu">
                        <li class="dash-item">
                            <a class="dash-link" href="{{ route('admin.menus.index') }}">
                                <span class="dash-micon"><i class="ti ti-menu"></i></span>
                                {{ __('Menus') }}
                            </a>
                        </li>
                        <li class="dash-item">
                            <a class="dash-link" href="{{ route('admin.pages.index') }}">
                                <span class="dash-micon"><i class="ti ti-page"></i></span>
                                {{ __('Pages') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Messages Section -->
                @can('Message')
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/messages*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-comment"></i></span>
                            <span class="dash-mtext">{{ __('Message') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/emails*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.emails.index') }}">
                                    <span class="dash-micon"><i class="ti ti-email"></i></span>
                                    {{ __('Email') }}
                                </a>
                            </li>
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/alerts*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.alerts.index') }}">
                                    <span class="dash-micon"><i class="ti ti-alert-circle"></i></span>
                                    {{ __('Alert') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                <!-- Contact Messages Section -->
                @can('Contact-Message')
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/form-contact*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="{{ route('admin.contact.index') }}" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-comments"></i></span>
                            <span class="dash-mtext">{{ __('Contact Message') }}</span>
                        </a>
                    </li>
                @endcan

                <!-- Blog Section -->
                @can('Blog')
                    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/blog*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link">
                            <span class="dash-micon"><i class="ti ti-book"></i></span>
                            <span class="dash-mtext">{{ __('Blogs') }}</span>
                            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="dash-submenu">
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/blogs*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.blog.index') }}">
                                    <span class="dash-micon"><i class="ti ti-pencil"></i></span>
                                    {{ __('Blog') }}
                                </a>
                            </li>
                            <li class="dash-item {{ request()->is('admin-panel/management/messages/category*') ? 'active' : '' }}">
                                <a class="dash-link" href="{{ route('admin.blog.category.index') }}">
                                    <span class="dash-micon"><i class="ti ti-tag"></i></span>
                                    {{ __('Category') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @endif



            </ul>
        </div>
    </div>
</nav>
