<div class="form-check mt-3 ">
    <input class="form-check-input" type="checkbox" value="1" id="CheckTermCondition_{{ $market->id }}"
           name="term_condition">
    <label class="form-check-label" for="flexCheckDefault">
        <strong>
            I Read and accept terms and conditions
        </strong>
        <span id="accept_term_alert" style="font-size: 9pt;color: red" class="ml-3">Accept Term and Conditions</span>
    </label>
</div>
<div class="bid_term_condition p-3 text-justify mt-3">
    {!! $market->SalesForm->term_conditions !!}
</div>
