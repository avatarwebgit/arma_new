<div class="nav flex-column nav-pills settings-nav" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <a class="nav-link {{ request()->is('seller/dashboard') ? 'active' : '' }}" href="{{ route('bidder.dashboard') }}">
        <i class="icon ion-md-person"></i>
        Dashboard
    </a>
    <a class="nav-link {{ request()->is('seller/profile') ? 'active' : '' }}" href="{{ route('bidder.profile') }}">
        <i class="icon ion-md-person"></i>
        Profile
    </a>
</div>

