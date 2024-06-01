<div  id="bid_deposit_section-{{ $market->id }}" class="bid_deposit p-3">
    <h4 class="text-center text-white">Bid Deposit: ${{ $market->bid_deposit }}</h4>
    {!! $bid_deposit_text_area !!}
    <div class="form-check">
        <input class="form-check-input" type="radio" value="1" id="Online"
               name="payment_type">
        <label class="form-check-label" for="Online">
            Online
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" value="2" id="Wallet"
               name="payment_type">
        <label class="form-check-label" for="Wallet">
            Wallet
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" value="Cash" id="3" name="payment_type">
        <label class="form-check-label" for="Cash">
            Cash
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" value="4" id="Account"
               name="payment_type">
        <label class="form-check-label" for="Account">
            Account
        </label>
    </div>

    <div>
        <button type="button" onclick="PayBidDeposit({{ $market->id }})" class="btn btn-primary">Pay</button>
    </div>
</div>
