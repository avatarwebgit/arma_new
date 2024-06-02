<div id="bid_deposit_section-{{ $market->id }}" class="bid_deposit p-3">

    @if ($wallet<$market->bid_deposit)
        <div class="alert alert-danger">
            You Must charge Your Wallet
        </div>
    @else
        <div class="alert alert-success">
            Congratulations!.You Can Bid
            <br>
            Your Wallet: {{ number_format($wallet).'$' }}
        </div>
    @endif
    <h4 class="text-center text-white">Bid Deposit: {{ number_format($market->bid_deposit).' $' }}</h4>
    {!! $bid_deposit_text_area !!}
    @if ($wallet<$market->bid_deposit)
        <div>
            <button type="button" onclick="PayBidDeposit({{ $market->id }})" class="btn btn-primary">Pay</button>
        </div>
    @endif
</div>
