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
                Sales Offer Form
            </a>
        </li>
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
                    Sales Offer Form
                </a>
            </li>
        </ul>
    </li>
@endcan

<li class="dash-item dash-hasmenu">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="fas fa-exchange-alt"></i></span>
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
        <span class="dash-micon"><i class="fas fa-comments"></i></span>
        <span class="dash-mtext">{{ __('Messages') }}</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="#">
                <span class="dash-micon"><i class="fas fa-user-shield"></i></span>
                Admin
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="#">
                <span class="dash-micon"><i class="fas fa-user"></i></span>
                Member
            </a>
        </li>
    </ul>
</li>
