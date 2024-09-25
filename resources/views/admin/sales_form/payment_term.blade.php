<div class="col-12">
    <hr>
    <strong>
        Payment Term
    </strong>
</div>

<div class="row" id="payment-term-box">
    <div class="col-12 col-md-3 mb-3">
        @php
            $name='LC';
        @endphp
        <div class="form-check">
            <input readonly onchange="paymentTermOptions()" class="form-check-input" type="checkbox" name="{{ filed_name($name) }}"
                   value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='OA';
        @endphp
        <div class="form-check">
            <input onchange="paymentTermOptions()" class="form-check-input" type="checkbox" name="{{ filed_name($name) }}"
                   value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='Other_Payment';
        @endphp
        <div class="form-check">
            <input onchange="paymentTermOptions()" class="form-check-input" type="checkbox" name="{{ filed_name($name) }}"
                   value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
        @php
            $name='TT';
        @endphp
        <div class="form-check">
            <input onchange="paymentTermOptions()" class="form-check-input" type="checkbox" name="{{ filed_name($name) }}"
                   value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='PayPal';
        @endphp
        <div class="form-check">
            <input onchange="paymentTermOptions()" class="form-check-input" type="checkbox" name="{{ filed_name($name) }}"
                   value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
        @php
            $name='DP';
        @endphp
        <div class="form-check">
            <input onchange="paymentTermOptions()" class="form-check-input" type="checkbox" name="{{ filed_name($name) }}"
                   value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='Western Union';
        @endphp
        <div class="form-check">
            <input onchange="paymentTermOptions()" class="form-check-input" type="checkbox" name="{{ filed_name($name) }}"
                   value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
    </div>
    <div class="col-12 col-md-3 mb-3">
        @php
            $name='DA';
        @endphp
        <div class="form-check">
            <input onchange="paymentTermOptions()" class="form-check-input" type="checkbox" name="{{ filed_name($name) }}"
                   value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
        @php
            $name='MoneyGram';
        @endphp
        <div class="form-check">
            <input onchange="paymentTermOptions()" class="form-check-input" type="checkbox" name="{{ filed_name($name) }}"
                   value="{{ filed_name($name) }}" id="{{ filed_name($name) }}">
            <label class="form-check-label" for="{{ filed_name($name) }}">
                {{ $name }}
            </label>
        </div>
    </div>
{{--    //textarea--}}
    @php
    $items=['LC','TT','DP','DA','OA','PayPal','Western Union','MoneyGram','Other_Payment'];
    @endphp
    @foreach($items as $item)

            @php
                $name=$item.' Term and Conditions';
                $is_required=1;
                $required_span='';
                $required='';
                        //common conditional
                if ($is_required===1){
                    $required_span='<span class="text-danger">*</span>';
                    $required='required';
                }
                if (old(filed_name($name)) !== null){
                    $value=old(filed_name($name));
                }else{
                    if ($sale_form_exist==1){
                        $value=$form[filed_name($name)];
                    }else{
                        $value=null;
                    }
                }
            @endphp
        <div class="col-12 col-md-6 mb-3 term_condition_option d-none" id="{{ filed_name($name).'_parent' }}">
            <label for="{{ filed_name($name) }}"
                   class="mb-2">{!! $name.' '.$required_span !!}</label>
            <textarea autocomplete="on" {{ $required }} id="{{ filed_name($name) }}" type="text"
                      name="{{ filed_name($name) }}" class="form-control">{{ $value }}</textarea>
            @error(filed_name($name))
            <p class="input-error-validate">
                {{ $message }}
            </p>
            @enderror
        </div>
    @endforeach


{{--    //endtextarea--}}
    <input type="hidden" name="payment_options" value="" id="payment_options">
    <input type="hidden" name="payment_count" value="" id="payment_count">
    <div class="col-12">
        @if($errors->has('payment_count') or $errors->has('payment_options'))
            <p class="input-error-validate">
                You Have To Choose At Least 2 Payment term
            </p>
        @endif
    </div>
</div>


