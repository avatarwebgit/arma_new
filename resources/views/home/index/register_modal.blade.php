<div class="modal fade" id="register_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div style="max-width: 630px !important;" class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="register_form_modal" class="auth-form">
                <div class="modal-header position-relative" style="border-bottom: none !important;">
                    <i style="position: absolute;top:0;right: 0" data-dismiss="modal" aria-label="Close"
                       class="fa fa-times-circle fa-2x"></i>

                </div>
                <h4 class="text-center">
                    Registery
                </h4>

                <div class="row">
                    <div class="col-12">
                        <h5 class="text-center d-flex align-items-center">
                            Company
                            <hr style="width: 83%">
                        </h5>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_name" class="mb-1">Company Name *</label>
                        <input
                            id="company_name"
                            type="text"
                            class="form-control"
                            name="company_name"
                            required>
                        <p id="company_name_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="user_type" class="mb-1">Company Type *</label>
                        <select
                            id="user_type"
                            type="text"
                            class="form-control"
                            name="user_type">
                            <option value="">Select User Type</option>
                            @foreach($types as $type)
                                <option
                                    {{ old('type')==$type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>

                        <p id="user_type_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_country" class="mb-1">Country *</label>
                        <select name="company_country" id="company_country" class="form-control">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option
                                    {{ old('company_country')==$country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->countryName }}</option>
                            @endforeach
                        </select>
                        <p id="company_country_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_address" class="mb-1">Address *</label>
                        <input
                            id="company_address"
                            type="text"
                            class="form-control"
                            name="company_address" required>
                        <p id="company_address_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_phone" class="mb-1">Main Telephone Number *</label>
                        <input
                            id="company_phone"
                            type="text"
                            class="form-control"
                            name="company_phone"
                            required>
                        <p id="company_phone_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_website" class="mb-1">Website</label>
                        <input
                            id="company_website"
                            type="text"
                            class="form-control"
                            name="company_website" required>
                        <p id="company_website_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_email" class="mb-1">Email *</label>
                        <input
                            id="company_email"
                            type="email"
                            class="form-control"
                            name="company_email"
                            required>
                        <p id="company_email_error" class="error-message d-none">

                        </p>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="commodity" class="mb-1">Commodities *</label>
                        <select name="commodity" id="commodity" class="form-control">
                            <option value="">Select Commodity</option>
                            @foreach($commodities as $commodity)
                                <option
                                    {{ old('commodity')==$commodity->id ? 'selected' : ''  }} value="{{ $commodity->id }}">
                                    {{ $commodity->title }}
                                </option>
                            @endforeach
                        </select>
                        <p id="commodity_error" class="error-message d-none">

                        </p>
                    </div>

                </div>


                <div class="row">
                    <div class="col-12">
                        <h5 class="text-center d-flex align-items-center">
                            User Details
                            <hr style="width: 75%">
                        </h5>
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label for="full_name" class="mb-1">Full Name *</label>
                        <input
                            id="full_name"
                            type="text"
                            class="form-control"
                            required>
                        <p id="full_name_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="salutation" class="mb-1">Salutation </label>
                        <select id="salutation"
                                type="text"
                                class="form-control"
                                name="salutation">
                            <option value="">Select</option>
                            @foreach($salutation as $item)
                                <option {{ old('salutation')==$item->id  ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        <p id="salutation_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="function_in_company" class="mb-1">Function in company *</label>
                        <select
                            id="function_in_company"
                            type="text"
                            class="form-control"
                            name="function_in_company">
                            <option value="">Select</option>
                            @foreach($companyFunction as $item)
                                <option
                                    {{ old('function_in_company')==$item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>

                        <p id="function_in_company_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="email" class="mb-1">Email *</label>
                        <input
                            id="email_register"
                            type="email"
                            class="form-control"
                            name="email"
                            required>
                        <p id="email_register_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="platform" class="mb-1">Platform *</label>
                        <select id="platform"
                                type="text"
                                class="form-control"
                                name="platform">
                            <option value="">Select</option>
                            @foreach($platforms as $platfotm)
                                <option value="{{ $platfotm->title }}">{{ $platfotm->title }}</option>
                            @endforeach

                        </select>
                        <p id="platform_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="mobile_no" class="mb-1">Mobile No *</label>
                        <input
                            id="mobile_no"
                            type="text"
                            class="form-control"
                            name="mobile_no"
                            required
                        >
                        <p id="mobile_no_error" class="error-message d-none">

                        </p>
                    </div>
                    <div class="form-group col-12">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="accept_term"
                                   id="accept_term"
                                   value="1"
                                   class="custom-control-input">
                            <label class="custom-control-label" for="accept_term">
                                I accept the
                                <a href="{{ route('home.menus',['menus'=>16]) }}">
                                    Term and Conditions
                                </a>
                            </label>
                            <p id="accept_term_error" class="error-message d-none">

                            </p>
                        </div>
                    </div>
                </div>


{{--                {!! NoCaptcha::renderJs() !!}--}}
{{--                {!! NoCaptcha::display() !!}--}}


                <div class="row">
                    <div class="col-12 col-md-4">
                        <button onclick="SubmitRegisterModal(this)" type="button"
                                class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
