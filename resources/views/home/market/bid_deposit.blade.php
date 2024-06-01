<div  id="bid_deposit_section-{{ $market->id }}" class="bid_deposit p-3">
    <h4 class="text-center text-white">Bid Deposit: ${{ $market->bid_deposit }}</h4>
    {!! $bid_deposit_text_area !!}
    <div>
        <button type="button" onclick="PayBidDeposit({{ $market->id }})" class="btn btn-primary">Pay</button>
    </div>
</div>
