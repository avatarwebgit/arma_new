<!-- Sales Order Section -->
<li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/orders*') ? 'active dash-trigger' : 'collapsed' }}">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="ti ti-package"></i></span>
        <span class="dash-mtext">{{ __('Sales Order') }}</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">

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
                        New
                    </a>
                </li>
                <li class="dash-item">
                    <a class="dash-link" href="{{ route('sale_form_list',['type'=>'Save']) }}">
                        <span class="dash-micon"><i class="ti ti-file"></i></span>
                        Save ( {{ $SalesFormCounts['Save'] }} )
                    </a>
                </li>
                <li class="dash-item">
                    <a class="dash-link" href="{{ route('sale_form_list',['type'=>'Draft']) }}">
                        <span class="dash-micon"><i class="ti ti-file"></i></span>
                        Draft ( {{ $SalesFormCounts['Draft'] }} )
                    </a>
                </li>
                <li class="dash-item">
                    <a class="dash-link" href="#">
                        <span class="dash-micon"><i class="ti ti-file"></i></span>
                       Previous
                    </a>
                </li>
                <li class="dash-item">
                    <a class="dash-link" href="#">
                        <span class="dash-micon"><i class="ti ti-file"></i></span>
                       Pendenig
                    </a>
                </li>
                <li class="dash-item">
                    <a class="dash-link" href="#">
                        <span class="dash-micon"><i class="ti ti-file"></i></span>
                       Offer Payment
                    </a>
                </li>
                <li class="dash-item">
                    <a class="dash-link" href="#">
                        <span class="dash-micon"><i class="ti ti-file"></i></span>
                       Rejected
                    </a>
                </li>
            </ul>
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
