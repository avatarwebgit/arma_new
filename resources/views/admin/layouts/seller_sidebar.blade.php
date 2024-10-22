<!-- Sales Order Section -->
<li class="dash-item dash-hasmenu {{ request()->is('admin-panel/management/orders*') ? 'active dash-trigger' : 'collapsed' }}">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="fas fa-shopping-cart"></i></span>
        <span class="dash-mtext">{{ __('Sales Order') }}</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <a class="dash-link" href="{{ route('sale_form', ['page_type' => 'Create']) }}">
                <span class="dash-micon"><i class="fas fa-plus-circle"></i></span>
                New
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="{{ route('sale_form_list',['type'=>'Save']) }}">
                <span class="dash-micon"><i class="fas fa-save"></i></span>
                Save ( {{ $SalesFormCounts['Save'] }} )
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="{{ route('sale_form_list',['type'=>'Draft']) }}">
                <span class="dash-micon"><i class="fas fa-file-alt"></i></span>
                Draft ( {{ $SalesFormCounts['Draft'] }} )
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="{{ route('sale_forms',['status'=>5]) }}">
                <span class="dash-micon"><i class="fas fa-history"></i></span>
                Previous
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="{{ route('sale_forms',['status'=>3]) }}">
                <span class="dash-micon"><i class="fas fa-clock"></i></span>
                Pending
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="{{ route('sale_forms',['status'=>2]) }}">
                <span class="dash-micon"><i class="fas fa-money-bill-wave"></i></span>
                Offer Payment
            </a>
        </li>
        <li class="dash-item">
            <a class="dash-link" href="{{ route('sale_forms',['status'=>4]) }}">
                <span class="dash-micon"><i class="fas fa-ban"></i></span>
                Rejected
            </a>
        </li>
    </ul>
</li>

<!-- Transactions Section -->
<li class="dash-item dash-hasmenu">
    <a href="#!" class="dash-link">
        <span class="dash-micon"><i class="fas fa-exchange-alt"></i></span>
        <span class="dash-mtext">{{ __('Transactions') }}</span>
        <span class="dash-arrow"><i data-feather="chevron-right"></i></span>
    </a>
    <ul class="dash-submenu">
        <li class="dash-item">
            <!-- Add your submenu items here -->
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
            <a class="dash-link" href="#">
                <span class="dash-micon"><i class="fas fa-user-shield"></i></span>
                Admin
            </a>
        </li>
    </ul>
</li>
