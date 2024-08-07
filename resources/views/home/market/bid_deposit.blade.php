<div git  class="bid_deposit p-3 bid_deposit_section-{{ $market->id }}">
    <h4 class="text-center text-white">Bid Deposit: {{ number_format($market->bid_deposit).' $' }}</h4>
    {!! $bid_deposit_text_area !!}
        <br>
        <strong>Your Wallet: {{ number_format($wallet).'$' }}</strong>
    @if ($wallet<$market->bid_deposit)
        <div class="d-flex justify-content-end">
            <button id="PayBidDepositBTN-{{ $market->id }}" type="button" onclick="PayBidDeposit({{ $market->id }})" class="btn pay-btn">Pay</button>
        </div>
    @endif
</div>
