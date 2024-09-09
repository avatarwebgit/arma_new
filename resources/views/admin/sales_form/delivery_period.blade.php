<div class="col-12 mb-1">
    <strong>
        Delivery Period
    </strong>
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $label='From';
        $name='Loading From';
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
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $label.' '.$required_span !!}</label>
    <input {{ $required }} id="{{ filed_name($name) }}" type="date"
           name="{{ filed_name($name) }}" class="form-control"
           value="{{ $value }}">
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $label='To';
        $name='Loading To';
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
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $label.' '.$required_span !!}</label>
    <input {{ $required }} id="{{ filed_name($name) }}" type="date"
           name="{{ filed_name($name) }}" class="form-control"
           value="{{ $value }}">
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
