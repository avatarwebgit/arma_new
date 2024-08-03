@extends($role=='seller'?'seller.layouts.main':'admin.layouts.main')

@section('content')
    @include('admin.sales_form.modal')

    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div id="settings-profile"
                             aria-labelledby="settings-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div>

                                        @if ($sale_form_exist==1)
                                            @if($form->is_complete===1)
                                                <a href="{{ route('admin.sales_form.index',['status'=>$form->Status->id]) }}" class="btn btn-dark mb-3">
                                                    Back
                                                </a>
                                            @endif

                                            <div>
                                                <p>No: {{ $form->unique_number }}</p>
                                                <p>Date: {{ $form->created_at->format('Y-M-d') }}</p>
                                                <p>
                                                    Status: {{ $form->is_complete===1?$form->Status->title:'The form is not complete' }}</p>
                                            </div>
                                        @endif
                                        <hr>
                                    </div>
                                    <div class="settings-profile">
                                        <form id="sales_form" method="POST" action="{{ $route }}"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div id="sales_offer_form_inputs" class="row">
                                                @include('admin.sales_form.company')

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

                                                @include('admin.sales_form.loading')

                                                @include('admin.sales_form.discharging')

                                                @include('admin.sales_form.destination')

                                                @include('admin.sales_form.inspection')

                                                @include('admin.sales_form.insurance')

                                                @include('admin.sales_form.safety')

                                                @include('admin.sales_form.reach_certificate')

                                                @include('admin.sales_form.documents')

                                                @include('admin.sales_form.contact_person')

                                                @include('admin.sales_form.last_section')
                                            </div>
                                            <div id="status_buttons" class="row">
                                                <div class="col-md-12 text-center">
                                                    <button title="Submit" type="button" onclick="submitForm()"
                                                            class="btn btn-info">
                                                        Submit
                                                    </button>
                                                </div>
                                                <div class="col-md-12" style="text-align: right">
                                                    <button title="Your Information Saved But Not Submitted"
                                                            type="button" onclick="submitForm(1)"
                                                            class="btn btn-sm btn-success">
                                                        Save
                                                    </button>
                                                    @if(request()->is('sale_form/Edit*'))

                                                    @else
                                                        <button title="Your Information Permanently deleted" type="button"
                                                                onclick="CancelForm({{ isset($form->id)?$form->id:0 }})"
                                                                class="btn btn-sm btn-danger">
                                                            Cancel
                                                        </button>
                                                    @endif

                                                    {{--                                                    @include('admin.sales_form.change_status')--}}
                                                </div>
                                            </div>
                                            <input id="is_save" name="is_save" type="hidden" value="0">
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
@endsection

@push('style')
    <!-- Font Awesome -->


    <style>
        @media (min-width: 576px) {
            #show_modal_form_exists .modal-dialog {
                max-width: 30% !important;
                margin: 1.75rem auto;
            }
        }
        .disabled{
            background: #c6c6c6;
            color: black;
        }
        #NeedToSubmitModal .modal-footer > button{
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
    </style>
@endpush

@push('script')
    @include('admin.sales_form.script')
@endpush

