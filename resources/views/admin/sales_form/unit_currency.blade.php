<div class="col-12">
    <strong>
        Unit and Currency
    </strong>
</div>

<div class="col-12 col-md-6 mb-3">
    @php
        $name='Unit';
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
           class="mb-2">{!! $name.' '.$required_span !!}</label>
    <select onchange="hasOther(this)"
            {{ $required }} id="{{ filed_name($name) }}" type="text"
            name="{{ filed_name($name) }}" class="form-control " data-live-search="true">
        @foreach($unites as $item)
            <option
                {{ $value==$item->title ? ' selected="selected"' : '' }} value="{{ $item->title }}">{{ $item->title }}</option>
        @endforeach
    </select>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Currency';
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
           class="mb-2">{!! $name.' '.$required_span !!}</label>
    <select onchange="hasOther(this)"
            {{ $required }} id="{{ filed_name($name) }}" type="text"
            name="{{ filed_name($name) }}" class="form-control" data-live-search="true">
        @foreach($currencies as $key=>$item)
            <option value="{{ $item->title }}"  {{ $value==$item->title ? 'selected' : '' }} data-content="<img src='{{ imageExist(env('UPLOAD_IMAGE_CURRENCY'),$item->image) }}' width='20'  /> {{ $item->title }}"></option>
        @endforeach
    </select>

    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12">
    <hr>
</div>
