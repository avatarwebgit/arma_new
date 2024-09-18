@extends($role=='seller'?'seller.layouts.main':'admin.layouts.main')

@section('content')
    @include('admin.sales_form.modal')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="contact-tab"
                                data-toggle="tab" data-target="#contact" type="button"
                                role="tab" aria-controls="contact" aria-selected="false">Term & Conditions
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link " id="home-tab"
                                data-toggle="tab" data-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">Sale Form
                        </button>
                    </li>

                </ul>

                <div class="tab-content" id="myTabContent">
                    @if($folder!=null)
                        <a href="{{ route('admin.markets.folder',['date'=>$folder]) }}"
                           class="btn btn-dark bt-sm mt-3">
                            Back
                        </a>
                    @else
                        <a href="{{ route('admin.sales_form.sixth.index',['status'=>6]) }}"
                           class="btn btn-dark bt-sm mt-3">
                            Back
                        </a>
                    @endif

                    <div class="tab-pane fade show active" id="contact"
                         role="tabpanel" aria-labelledby="contact-tab">
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <form id="term_form"
                                          action="{{ route('sale_form.preparation_store',['form_id'=>$form->id]) }}"
                                          method="post" class="card-body" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 col-md-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div id="commodity_information" style="width: 100%">
                                                            <h5 class="text-center text-white text-center p-3 commodity-title bg-dark mb-0">
                                                                {{ $form->commodity }}
                                                            </h5>
                                                            @if($form->type_grade==null or $form->type_grade=='')

                                                            @else
                                                                <div class="d-flex justify-content-between">
                                                                    <span
                                                                        class="text-bold text-gray-100">Type/Grade</span>
                                                                    <span
                                                                        class="text-bold text-light-blue ">{{ $form->type_grade }}</span>
                                                                </div>
                                                            @endif
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">Supplier</span>
                                                                <span class="text-bold text-light-blue ">
                            {{ $form->company_type }}
                        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span
                                                                    class="text-bold text-gray-100">Contract Type</span>
                                                                <span class="text-bold text-light-blue ">
                            {{ $form->contract_type }}
                        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span
                                                                    class="text-bold text-gray-100">Max Quantity</span>
                                                                @php
                                                                    $maxQuantity=str_replace(',','',$form->max_quantity);
                                                                @endphp
                                                                <span
                                                                    class="text-bold text-light-blue ">{{ number_format($maxQuantity) }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">Min Order</span>
                                                                @php
                                                                    $minQuantity=str_replace(',','',$form->min_order);
                                                                @endphp
                                                                <span
                                                                    class="text-bold text-light-blue ">{{ number_format($minQuantity) }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">Price Type</span>
                                                                <span
                                                                    class="text-bold text-light-blue ">{{ $form->price_type }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">Offer Price</span>
                                                                <span class="text-bold text-light-blue ">
{{--                           {{ $market->offer_price }}--}}
                                                                    @if($form->price_type=='Fix')
                                                                        <td class="text-center">{{ number_format($form->price) }}</td>
                                                                    @else
                                                                        <td class="text-center">{{ number_format($form->alpha)  }}</td>
                                                                    @endif
                        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">Payment</span>
                                                                <span class="text-bold text-light-blue ">
                            {{ $form->payment_term }}
                        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">packaging</span>
                                                                <span class="text-bold text-light-blue ">
                            {{ $form->packing }}
                        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">Term</span>
                                                                <span class="text-bold text-light-blue ">
            {{ $form->incoterms }}
        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span
                                                                    class="text-bold text-gray-100">Delivery period</span>
                                                                <span
                                                                    class="text-bold text-light-blue ">{{ $form->loading_from }}</span>
                                                            </div>

                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">Origin</span>
                                                                <span class="text-bold text-light-blue ">
                           {{ $form->origin_country }}
                        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span
                                                                    class="text-bold text-gray-100">Specification</span>
                                                                <span class="text-bold text-light-blue ">
                           {{ $form->specification }}
                        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">Unit</span>
                                                                <span class="text-bold text-light-blue ">
            {{ $form->unit }}
        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">Currency</span>
                                                                <span class="text-bold text-light-blue ">
            {{ $form->currency }}
        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-bold text-gray-100">GTC</span>
                                                                <span class="text-bold text-light-blue ">
            @if($form->gtc_use=='Link')
                                                                        <a target="_blank"
                                                                           href="{{ $form->gtc_Link }}">
                            Download
                        </a>
                                                                    @else
                                                                        <a target="_blank"
                                                                           href="{{ imageExist(env('UPLOAD_SETTING'),$form->gtc_file) }}">
                            Download
                        </a>
                                                                    @endif

                        </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span
                                                                    class="text-bold text-gray-100">Bid Instruction</span>
                                                                <span class="text-bold text-light-blue ">
                           @if($form->bid_use=='Link')
                                                                        <a target="_blank"
                                                                           href="{{ $form->Bid_Instructions_link }}">
                            Download
                        </a>
                                                                    @else
                                                                        <a target="_blank"
                                                                           href="{{ imageExist(env('UPLOAD_SETTING'),$form->Bid_Instructions_file) }}">
                            Download
                        </a>
                                                                    @endif
                        </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row h-100 align-items-center mt-3">
                                                            <div class="mb-2">
                                                                <label class="mb-2">Specifications</label>
                                                                <div
                                                                    class="col-12 d-flex align-items-end justify-content-between">
                                                                    <div class="w-80">
                                                                        <input type="file" class="form-control"
                                                                               name="specification_file">
                                                                    </div>
                                                                    <div>
                                                                        @if($form->specification_file==null or $form->specification_file=='')
                                                                            <button disabled
                                                                                    class="p-2 ml-2 bg-danger text-white">
                                                                                No File
                                                                            </button>
                                                                        @else
                                                                            <a target="_blank"
                                                                               class="btn btn-primary ml5"
                                                                               href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$form->specification_file)) }}">
                                                                                <i class="fa fa-file fa-2x"></i>
                                                                            </a>

                                                                            <button type="button"
                                                                                    onclick="RemoveFile('specification_file')"
                                                                                    class="btn btn-danger ml5">
                                                                                <i class="fa fa-times-circle fa-2x"></i>
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="mb-2">Analysis</label>
                                                                <div
                                                                    class="col-12 d-flex align-items-end justify-content-between ">
                                                                    <div class="w-80">
                                                                        <input type="file" class="form-control"
                                                                               name="quality_inspection_report_file">
                                                                    </div>
                                                                    <div>
                                                                        @if($form->quality_inspection_report_file==null or $form->quality_inspection_report_file=='')
                                                                            <button disabled
                                                                                    class="p-2 ml-2 bg-danger text-white">
                                                                                No File
                                                                            </button>
                                                                        @else
                                                                            <a target="_blank"
                                                                               class="btn btn-primary ml5"
                                                                               href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$form->quality_inspection_report_file)) }}">
                                                                                <i class="fa fa-file fa-2x"></i>
                                                                            </a>

                                                                            <button type="button"
                                                                                    onclick="RemoveFile('quality_inspection_report_file')"
                                                                                    class="btn btn-danger ml5">
                                                                                <i class="fa fa-times-circle fa-2x"></i>
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="mb-2">Pictures</label>
                                                                <div
                                                                    class="col-12 d-flex align-items-end justify-content-between ">
                                                                    <div class="w-80">

                                                                        <input type="file" class="form-control"
                                                                               name="picture_packing_file">
                                                                    </div>
                                                                    <div>
                                                                        @if($form->picture_packing_file==null or $form->picture_packing_file=='')
                                                                            <button disabled
                                                                                    class="p-2 ml-2 bg-danger text-white">
                                                                                No File
                                                                            </button>
                                                                        @else
                                                                            <a target="_blank"
                                                                               class="btn btn-primary ml5"
                                                                               href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$form->picture_packing_file)) }}">
                                                                                <i class="fa fa-file fa-2x"></i>
                                                                            </a>

                                                                            <button type="button"
                                                                                    onclick="RemoveFile('picture_packing_file')"
                                                                                    class="btn btn-danger ml5">
                                                                                <i class="fa fa-times-circle fa-2x"></i>
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="mb-2">MSDS</label>
                                                                <div
                                                                    class="col-12 d-flex align-items-end justify-content-between ">
                                                                    <div class="w-80">
                                                                        <input type="file" class="form-control"
                                                                               name="safety_product_file">
                                                                    </div>
                                                                    <div>
                                                                        @if($form->safety_product_file==null or $form->safety_product_file=='')
                                                                            <button disabled
                                                                                    class="p-2 ml-2 bg-danger text-white">
                                                                                No File
                                                                            </button>
                                                                        @else
                                                                            <a target="_blank"
                                                                               class="btn btn-primary ml5"
                                                                               href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$form->safety_product_file)) }}">
                                                                                <i class="fa fa-file fa-2x"></i>
                                                                            </a>

                                                                            <button type="button"
                                                                                    onclick="RemoveFile('safety_product_file')"
                                                                                    class="btn btn-danger ml5">
                                                                                <i class="fa fa-times-circle fa-2x"></i>
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="mb-2">Reach Certificate</label>
                                                                <div
                                                                    class="col-12 d-flex align-items-end justify-content-between ">
                                                                    <div class="w-80">

                                                                        <input type="file" class="form-control"
                                                                               name="reach_certificate_file">
                                                                    </div>
                                                                    <div>
                                                                        @if($form->reach_certificate_file==null or $form->reach_certificate_file=='')
                                                                            <button disabled
                                                                                    class="p-2 ml-2 bg-danger text-white">
                                                                                No File
                                                                            </button>
                                                                        @else
                                                                            <a target="_blank"
                                                                               class="btn btn-primary ml5"
                                                                               href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$form->reach_certificate_file)) }}">
                                                                                <i class="fa fa-file fa-2x"></i>
                                                                            </a>

                                                                            <button type="button"
                                                                                    onclick="RemoveFile('reach_certificate_file')"
                                                                                    class="btn btn-danger ml5">
                                                                                <i class="fa fa-times-circle fa-2x"></i>
                                                                            </button>
                                                                        @endif


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-9">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="term_conditions">Term & Conditions</label>
                                                        <textarea rows="20" class="form-control mt-3"
                                                                  name="term_conditions"
                                                                  id="term_conditions">{{ old('term_conditions') !== null ? old('term_conditions') : $form->term_conditions }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <input type="hidden" name="form_type" id="form_type">
                                        <div class="d-flex justify-content-center mt-5">
                                            {{--                                            <a href="{{ route('admin.sales_form.sixth.index',['status'=>6]) }}"--}}
                                            {{--                                               class="button-theme mt-3">--}}
                                            {{--                                                Cancel--}}
                                            {{--                                            </a>--}}
                                            @unless($folder)
                                                <button onclick="submitForm('confirm')" type="button"
                                                        class="btn btn-info ms-2 px-4">
                                                    Approve
                                                </button>
                                            @endif

                                            <button onclick="submitForm('save')" type="button"
                                                    class="btn btn-warning px-4">
                                                Save
                                            </button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="home"
                         role="tabpanel" aria-labelledby="home-tab">
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div id="settings-profile"
                                         aria-labelledby="settings-profile-tab">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="settings-profile">
                                                    <form id="sales_form" method="POST" action="{{ $route }}"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        <div id="sales_offer_form_inputs" class="row">
                                                            <div class="col-12">
                                                                <h5>Cargo Owner</h5>
                                                                <hr>
                                                            </div>
                                                            <div class="col-12">
    <span class="cargo-note">
        Note: Only Cargo Owner Can Submit the Sales Offer Form
    </span>
                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">

                                                                @php
                                                                    $label='Name/Company';
                                                                    $name='Company Name';
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
                                                                <input {{ $required }} id="{{ filed_name($name) }}"
                                                                       type="text"
                                                                       name="{{ filed_name($name) }}"
                                                                       class="form-control"
                                                                       value="{{ $value }}">
                                                                @error(filed_name($name))
                                                                <p class="input-error-validate">
                                                                    {{ $message }}
                                                                </p>
                                                                @enderror
                                                            </div>
                                                            <div class="col-12 col-md-6 mb-3">
                                                                @php
                                                                    $label='Type';
                                                                    $name='Company Type';
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
                                                                <select {{ $required }} id="{{ filed_name($name) }}"
                                                                        type="text"
                                                                        name="{{ filed_name($name) }}"
                                                                        class="form-control ">
                                                                    @foreach($company_types as $item)
                                                                        <option
                                                                            {{ $value==$item->title? 'selected' : '' }} value="{{ $item->title }}">{{ $item->title }}</option>
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


                                                            @include('admin.sales_form.unit_currency')

                                                            @include('admin.sales_form.contract')

                                                            @include('admin.sales_form.product')

                                                            @include('admin.sales_form.quantity')

                                                            @include('admin.sales_form.quality')

                                                            @include('admin.sales_form.incoterm')

                                                            @include('admin.sales_form.price_type')

                                                            @include('admin.sales_form.payment_term')

                                                            @include('admin.sales_form.packing')

                                                            @include('admin.sales_form.origin')

                                                            @include('admin.sales_form.delivery_period')

                                                            @include('admin.sales_form.loading')

                                                            @include('admin.sales_form.discharging')

                                                            @include('admin.sales_form.destination')

                                                            @include('admin.sales_form.inspection')

                                                            @include('admin.sales_form.insurance')

                                                            @include('admin.sales_form.safety')

                                                            @include('admin.sales_form.reach_certificate')

                                                            @include('admin.sales_form.documents')

                                                            @include('admin.sales_form.contact_person')

                                                            {{--                                                            @include('admin.sales_form.last_section')--}}
                                                        </div>
                                                        <div id="status_buttons" class="row">
                                                            <div class="col-md-12 text-center">
                                                                <button title="Submit" type="button"
                                                                        onclick="SaleEdit()"
                                                                        class="btn btn-info">
                                                                    Edit
                                                                </button>
                                                            </div>
                                                            {{--                                                            <div class="col-md-12" style="text-align: right">--}}
                                                            {{--                                                                <button title="Your Information Saved But Not Submitted"--}}
                                                            {{--                                                                        type="button" onclick="submitForm(1)"--}}
                                                            {{--                                                                        class="btn btn-sm btn-success">--}}
                                                            {{--                                                                    Save--}}
                                                            {{--                                                                </button>--}}
                                                            {{--                                                                @if(request()->is('sale_form/Edit*'))--}}

                                                            {{--                                                                @else--}}
                                                            {{--                                                                    <button title="Your Information Permanently deleted"--}}
                                                            {{--                                                                            type="button"--}}
                                                            {{--                                                                            onclick="CancelForm({{ isset($form->id)?$form->id:0 }})"--}}
                                                            {{--                                                                            class="btn btn-sm btn-danger">--}}
                                                            {{--                                                                        Cancel--}}
                                                            {{--                                                                    </button>--}}
                                                            {{--                                                                @endif--}}

                                                            {{--                                                                --}}{{--                                                    @include('admin.sales_form.change_status')--}}
                                                            {{--                                                            </div>--}}
                                                        </div>
                                                        <input id="status" name="status" type="hidden" value="6">
                                                        <input id="is_save" name="is_save" type="hidden" value="0">
                                                        <input id="accept_terms" name="accept_terms" type="hidden" value="1">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" id="remove_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 400px">
            <div class="modal-content">
                <div class="modal-header">

                    <h3>
                        Are You Sure ?
                    </h3>
                    <i data-dismiss="modal" aria-label="Close" class="fa fa-times-circle fa-2x"></i>

                </div>
                <div id="modal_body" class="modal-body p-5 row">

                </div>
                <div class="modal-footer">
                    <input id="form_id" type="hidden" value="">
                    <input id="field" type="hidden" value="">
                    <button type="button" class="btn btn-info" data-dismiss="modal">
                        Cancel
                    </button>
                    <button onclick="RemoveFileModal()" type="button" class="btn btn-danger">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"
          integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <style>
        .w-80 {
            width: 80%;
        }

        .h-100 {
            height: 100%;
        }

        #commodity_information > div:nth-child(2n) {
            background-color: #efefef;
        }

        #commodity_information > div:nth-child(2n+1) {
            background-color: #dcdcdc;
        }

        #commodity_information span {
            padding: 5px 10px;
        }

        @media (min-width: 576px) {
            #show_modal_form_exists .modal-dialog {
                max-width: 30% !important;
                margin: 1.75rem auto;
            }
        }

        .disabled {
            background: #c6c6c6;
            color: black;
        }

        #NeedToSubmitModal .modal-footer > button {
            background: white !important;
            color: black !important;
            border: 1px solid black;
            margin: 5px 16px;
            width: 140px;
        }

        .form-control:disabled,
        .custom-select:disabled,
        .dataTable-selector:disabled,
        .dataTable-input:disabled,
        .form-control[readonly],
        .custom-select[readonly],
        .dataTable-selector[readonly],
        .dataTable-input[readonly] {
            background-color: #ffffff !important;
            opacity: 1;
            color: #606060;
        }

        #cke_1_contents {
            height: 800px !important;
        }

        .button-theme {
            padding: 5px;
            width: 130px;
            margin: 5px;
            background: white;
            border: 1px solid;
            display: block;
            text-align: center;
            color: black;
        }
    </style>
@endpush

@push('script')
    @include('admin.sales_form.script')

    <script>
        function SaleEdit() {
            $('#sales_form').submit();
        }

        function submitForm(type) {
            $('#form_type').val(type);
            $('#term_form').submit();
        }

        function RemoveFile(file_name) {
            let id = "{{ $form->id }}";
            $('#remove_modal').modal('show');
            $('#form_id').val(id);
            $('#field').val(file_name);
        }

        function RemoveFileModal() {
            let id = $('#form_id').val();
            let file_name = $('#field').val();
            $.ajax({
                url: "{{ route('sale_form.preparation.remove_file') }}",
                dataType: "json",
                method: "post",
                data: {
                    id: id,
                    file_name: file_name,
                    _token: "{{ csrf_token() }}"
                },
                success: function (msg) {
                    window.location.reload();
                }
            })
        }
    </script>

    <script src="{{ asset('admin/fullCKEditor/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('term_conditions', {
            language: 'en',
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush

