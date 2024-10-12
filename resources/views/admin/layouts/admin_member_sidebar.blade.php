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
        <span class="dash-micon"><i class="fas fa-users"></i></span>
        <span class="dash-mtext">{{ __('Users') }}</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        @can('Users-Inbox')
            <li class="dash-item {{ request()->is('users/1*') ? 'active' : '' }}">
                <a class="dash-link" href="{{ route('admin.users.zero.index', ['type' => 0]) }}">
                    <span class="dash-micon"><i class="fas fa-inbox"></i></span>
                    Inbox ({{ $userCounts['index'] }})
                </a>
            </li>
        @endcan
        @can('Users-Registering')
            <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                <a class="dash-link" href="{{ route('admin.users.first.index', ['type' => 1]) }}">
                    <span class="dash-micon"><i class="fas fa-user-plus"></i></span>
                    Registering ({{ $userCounts['registering'] }})
                </a>
            </li>
        @endcan
        @can('Users-Rejected')
            <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                <a class="dash-link" href="{{ route('admin.users.third.index', ['type' => 3]) }}">
                    <span class="dash-micon"><i class="fas fa-user-times"></i></span>
                    Rejected ({{ $userCounts['rejected'] }})
                </a>
            </li>
        @endcan
        @can('Users-Confirmed')
            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.users.second.index', ['type' => 2]) }}">
                    <span class="dash-micon"><i class="fas fa-user-check"></i></span>
                    Confirmed ({{ $userCounts['confirmed'] }})
                </a>
            </li>
        @endcan
        @can('Users-Sellers')
            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.users.seller.index', ['type' => 'seller']) }}">
                    <span class="dash-micon"><i class="fas fa-shopping-cart"></i></span>
                    Sellers ({{ $roleCounts['sellers'] }})
                </a>
            </li>
        @endcan
        @can('Users-Buyers')
            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.users.buyer.index', ['type' => 'buyer']) }}">
                    <span class="dash-micon"><i class="fas fa-shopping-basket"></i></span>
                    Buyers ({{ $roleCounts['buyers'] }})
                </a>
            </li>
        @endcan
        @can('Users-Brokers')
            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.users.brokers.index', ['type' => 'Brokers']) }}">
                    <span class="dash-micon"><i class="fas fa-briefcase"></i></span>
                    Brokers ({{ $roleCounts['brokers'] }})
                </a>
            </li>
        @endcan
        @can('Users-Members')
            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.users.members.index', ['type' => 'Members']) }}">
                    <span class="dash-micon"><i class="fas fa-user"></i></span>
                    Members ({{ $roleCounts['members'] }})
                </a>
            </li>
        @endcan
        @can('Users-Representatives')
            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.users.Representatives.index', ['type' => 'Representatives']) }}">
                    <span class="dash-micon"><i class="fas fa-user-tag"></i></span>
                    Representatives ({{ $roleCounts['representatives'] }})
                </a>
            </li>
        @endcan
        <li class="dash-item">
            <a class="dash-link" href="{{ route('admin.users.status', ['status' => 2]) }}">
                <span class="dash-micon"><i class="fas fa-user-slash"></i></span>
                Suspended ({{ $userCounts['suspended'] }})
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="{{ route('admin.users.status', ['status' => 3]) }}">
                <span class="dash-micon"><i class="fas fa-user-lock"></i></span>
                Blocked ({{ $userCounts['blocked'] }})
            </a>
        </li>
    </ul>
</li>

<!-- Inquiries Section -->
@php
    $inquiryCounts = [
        'inbox' => \App\Models\SalesOfferForm::where('status', 1)->whereNotNull('form_id')->where('used_in_market', 0)->count(),
        'cash_pending' => \App\Models\SalesOfferForm::where('status', 2)->where('form_id', '!=', null)->where('used_in_market', 0)->count(),
        'data_pending' => \App\Models\SalesOfferForm::where('status', 3)->where('form_id', '!=', null)->where('used_in_market', 0)->count(),
        'rejected' => \App\Models\SalesOfferForm::where('status', 4)->where('form_id', '!=', null)->where('used_in_market', 0)->count(),
        'approved' => \App\Models\SalesOfferForm::where('status', 5)->where('form_id', '!=', null)->where('used_in_market', 0)->count(),
        'preparation' => \App\Models\SalesOfferForm::where('status', 6)->where('form_id', '!=', null)->where('used_in_market', 0)->count(),
    ];
@endphp

<li class="dash-item">
    <a href="#!" class="dash-link position-relative">
        <span class="dash-micon"><i class="fas fa-file-alt"></i></span>
        <span class="dash-mtext custom-weight">{{ __('Inquiries') }}</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
        @can('Inquires-Inbox')
            <li class="dash-item">
                <a href="{{ route('admin.sales_form.first.index', ['status' => 1]) }}" class="dash-link">
                    <span class="dash-micon"><i class="fas fa-inbox"></i></span>
                    {{ __('Inbox') }} ({{ $inquiryCounts['inbox'] }})
                </a>
            </li>
        @endcan
        @can('Inquires-Cash-Pending')
            <li class="dash-item">
                <a href="{{ route('admin.sales_form.second.index', ['status' => 2]) }}" class="dash-link">
                    <span class="dash-micon"><i class="fas fa-money-bill-wave"></i></span>
                    {{ __('Offer Payment') }} ({{ $inquiryCounts['cash_pending'] }})
                </a>
            </li>
        @endcan
        @can('Inquires-Data-Pending')
            <li class="dash-item">
                <a href="{{ route('admin.sales_form.third.index', ['status' => 3]) }}" class="dash-link">
                    <span class="dash-micon"><i class="fas fa-exclamation-triangle"></i></span>
                    {{ __('Data Pending') }} ({{ $inquiryCounts['data_pending'] }})
                </a>
            </li>
        @endcan
        @can('Inquires-Rejected-Inquiries')
            <li class="dash-item">
                <a href="{{ route('admin.sales_form.forth.index', ['status' => 4]) }}" class="dash-link">
                    <span class="dash-micon"><i class="fas fa-times-circle"></i></span>
                    {{ __('Rejected') }} ({{ $inquiryCounts['rejected'] }})
                </a>
            </li>
        @endcan
        @can('Inquires-Preparation')
            <li class="dash-item">
                <a href="{{ route('admin.sales_form.sixth.index', ['status' => 6]) }}" class="dash-link">
                    <span class="dash-micon"><i class="fas fa-hourglass-half"></i></span>
                    {{ __('Preparation') }} ({{ $inquiryCounts['preparation'] }})
                </a>
            </li>
        @endcan
        @can('Inquires-Approved')
            <li class="dash-item">
                <a href="{{ route('admin.sales_form.fifth.index', ['status' => 5]) }}" class="dash-link">
                    <span class="dash-micon"><i class="fas fa-check-circle"></i></span>
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
        <span class="dash-micon"><i class="fas fa-store"></i></span>
        <span class="dash-mtext">{{ __('Markets') }}</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        @can('Market-Markets')
            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.markets.index') }}">
                    <span class="dash-micon"><i class="fas fa-th-list"></i></span>
                    Markets ({{ $market_count }})
                </a>
            </li>
        @endcan
        @can('Market-Setting')
            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.markets.settings') }}">
                    <span class="dash-micon"><i class="fas fa-cog"></i></span>
                    {{ __('Market Setting') }}
                </a>
            </li>
        @endcan
    </ul>
</li>

@can('Sales-Order-Sales-Offer-form')
    <!-- Sales Order Section -->
    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/orders*') ? 'active dash-trigger' : 'collapsed' }}">
        <a href="#!" class="dash-link">
            <span class="dash-micon"><i class="fas fa-box"></i></span>
            <span class="dash-mtext">{{ __('Sales Order') }}</span>
            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
        </a>
        <ul class="dash-submenu">
            <li class="dash-item">
                <a class="dash-link" href="{{ route('sale_form', ['page_type' => 'Create']) }}">
                    <span class="dash-micon"><i class="fas fa-file-alt"></i></span>
                    New
                </a>
            </li>
            <li class="dash-item">
                <a class="dash-link" href="{{ route('sale_form_list',['type'=>'Save']) }}">
                    <span class="dash-micon"><i class="fas fa-file-alt"></i></span>
                    Save ( {{ $SalesFormCounts['Save'] }} )
                </a>
            </li>
            <li class="dash-item">
                <a class="dash-link" href="{{ route('sale_form_list',['type'=>'Draft']) }}">
                    <span class="dash-micon"><i class="fas fa-file-alt"></i></span>
                    Draft ( {{ $SalesFormCounts['Draft'] }} )
                </a>
            </li>
        </ul>
    </li>
@endcan

<!-- Transactions Section -->
<li class="dash-item dash-hasmenu">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="fas fa-exchange-alt"></i></span>
        <span class="dash-mtext">{{ __('Transactions') }}</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="">
                <span class="dash-micon"><i class="fas fa-file-alt"></i></span>
                1
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="#">
                <span class="dash-micon"><i class="fas fa-file-alt"></i></span>
                2
            </a>
        </li>
    </ul>
</li>

<!-- Messages Section -->
<li class="dash-item dash-hasmenu">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="fas fa-comments"></i></span>
        <span class="dash-mtext">{{ __('Messages') }}</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="">
                <span class="dash-micon"><i class="fas fa-globe"></i></span>
                Websites (2)
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="#">
                <span class="dash-micon"><i class="fas fa-user-tie"></i></span>
                Sellers (1)
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="#">
                <span class="dash-micon"><i class="fas fa-user"></i></span>
                Buyers (5)
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="#">
                <span class="dash-micon"><i class="fas fa-user-md"></i></span>
                Brokers (4)
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="#">
                <span class="dash-micon"><i class="fas fa-user-check"></i></span>
                Representatives (4)
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="#">
                <span class="dash-micon"><i class="fas fa-users"></i></span>
                Members (41)
            </a>
        </li>
    </ul>
</li>

<!-- Bid Deposit Section -->
@can('Bid-Deposit-Refund-Request')
    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/bid*') ? 'active dash-trigger' : 'collapsed' }}">
        <a href="#!" class="dash-link">
            <span class="dash-micon"><i class="fas fa-money-bill-wave"></i></span>
            <span class="dash-mtext">{{ __('Bid Deposit') }}</span>
            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
        </a>
        <ul class="dash-submenu">
            @php
                $refund = \App\Models\Refund::where('status', '<', 3)->count();
            @endphp
            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.refund_request') }}">
                    <span class="dash-micon"><i class="fas fa-arrow-alt-circle-up"></i></span>
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
            <span class="dash-micon"><i class="fas fa-list-ol"></i></span>
            <span class="dash-mtext custom-weight">{{ __('Line |') }}</span>
        </a>
    </li>
@endcan

@can('Line-2')
    <li class="dash-item">
        <a href="{{ route('admin.header2.index') }}" class="dash-link">
            <span class="dash-micon"><i class="fas fa-list-ol"></i></span>
            <span class="dash-mtext custom-weight">{{ __('Line ||') }}</span>
        </a>
    </li>
@endcan

@if($role == 'admin')
    <!-- Settings Section -->
    <li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/settings*') ? 'active' : '' }}">
        <a href="#!" class="dash-link">
            <span class="dash-micon"><i class="fas fa-cogs"></i></span>
            <span class="dash-mtext">{{ __('Settings') }}</span>
            <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
        </a>
        <ul class="dash-submenu">
            @can('Settings-Setting')
                <li class="dash-item">
                    <a class="dash-link" href="{{ route('admin.settings.index',['type'=>'header']) }}">
                        <span class="dash-micon"><i class="fas fa-header"></i></span>
                        {{ __('Header') }}
                    </a>
                </li>
                <li class="dash-item">
                    <a class="dash-link" href="{{ route('admin.settings.index',['type'=>'footer']) }}">
                        <span class="dash-micon"><i class="fas fa-footer"></i></span>
                        {{ __('Footer') }}
                    </a>
                </li>
                <li class="dash-item">
                    <a class="dash-link" href="{{ route('admin.settings.index',['type'=>'general']) }}">
                        <span class="dash-micon"><i class="fas fa-cogs"></i></span>
                        {{ __('General') }}
                    </a>
                </li>
                <li class="dash-item">
                    <a class="dash-link" href="{{ route('admin.menus.index') }}">
                        <span class="dash-micon"><i class="fas fa-list"></i></span>
                        {{ __('Menus') }}
                    </a>
                </li>
                <li class="dash-item">
                    <a class="dash-link" href="{{ route('admin.pages.index') }}">
                        <span class="dash-micon"><i class="fas fa-file"></i></span>
                        {{ __('Pages') }}
                    </a>
                </li>
            @endcan
            @can('Settings-Currency')
                <li class="dash-item">
                    <a class="dash-link" href="{{ route('admin.currencies.index') }}">
                        <span class="dash-micon"><i class="fas fa-dollar-sign"></i></span>
                        {{ __('Currency') }}
                    </a>
                </li>
            @endcan

            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.countries.index') }}">
                    <span class="dash-micon"><i class="fas fa-flag"></i></span>
                    {{ __('Country') }}
                </a>
            </li>

            <li class="dash-item">
                <a class="dash-link" href="{{ route('admin.packages.index') }}">
                    <span class="dash-micon"><i class="fas fa-gift"></i></span>
                    {{ __('Package') }}
                </a>
            </li>

        </ul>
    </li>
@endif
