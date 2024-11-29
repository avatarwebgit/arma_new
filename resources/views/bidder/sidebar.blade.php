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
    <a class="nav-link {{ request()->is('bidder/refund_request') ? 'active' : '' }} position-relative" href="{{ route('bidder.refund_request') }}">
        @php
            $refund=\App\Models\Refund::where('user_id',auth()->id())->where('status','<',3)->get();
        @endphp
        <i class="icon ion-md-person"></i>
        <span class="dash-mtext custom-weight ">
                                My Refund Request @if(count($refund)>0)
                <span class="circle_alert">{{ count($refund) }}</span>
            @endif
                            </span>
    </a>
</div>

