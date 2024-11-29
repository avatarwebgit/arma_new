<div class="col-12 mb-3">
    @php
        $label='Term and Conditions';
            $name='term_conditions';
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

    <label>{{ $label }}</label>{!! $required_span !!}
    <textarea rows="10" id="{{ filed_name($name) }}" name="{{ filed_name($name) }}" class="form-control {{ filed_name($name) }}">{{ $value }}</textarea>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12">
    <hr>
</div>
