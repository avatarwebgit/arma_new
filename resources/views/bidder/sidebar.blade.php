<div class="nav flex-column nav-pills settings-nav" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <a class="nav-link {{ request()->is('bidder/dashboard') ? 'active' : '' }}" href="{{ route('bidder.dashboard') }}">
        <i class="icon ion-md-person"></i>
        Dashboard
    </a>
    <a class="nav-link {{ request()->is('bidder/profile') ? 'active' : '' }}" href="{{ route('bidder.profile') }}">
        <i class="icon ion-md-person"></i>
        Profile
    </a>
    <a class="nav-link {{ request()->is('bidder/wallet') ? 'active' : '' }}" href="{{ route('bidder.wallet') }}">
        <i class="icon ion-md-person"></i>
        Wallet
    </a>
</div>

