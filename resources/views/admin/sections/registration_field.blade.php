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
            disabled
            id="company_name"
            type="text"
            class="form-control"
            name="company_name"
            value="{{ $user->company_name }}"
            required>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="user_type" class="mb-1">Company Type *</label>

        <input
            disabled
            id="user_type"
            type="text"
            class="form-control"
            name="user_type"
            @if($user->user_type==2)
                value="Seller"
            @elseif($user->user_type==3)
                value="Buyer"
            @else
                value="Broker"
            @endif

        >
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_country" class="mb-1">Country *</label>
        <input
            disabled
            name="company_country"
            id="company_country"
            class="form-control"
            value="{{ $user->company_country }}"
        >

    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_address" class="mb-1">Address *</label>
        <input
            disabled
            id="company_address"
            type="text"
            class="form-control"
            name="company_address"
            value="{{ $user->company_address }}"
        >

    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_phone" class="mb-1">Main Telephone Number *</label>
        <input
            disabled
            id="company_phone"
            type="text"
            class="form-control"
            name="company_phone"
            value="{{ $user->company_phone }}"
        >
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_website" class="mb-1">Website</label>
        <input
            disabled
            id="company_website"
            type="text"
            class="form-control"
            name="company_website"
            value="{{ $user->company_website }}"
        >

    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_email" class="mb-1">Email *</label>
        <input
            disabled
            id="company_email"
            type="email"
            class="form-control"
            name="company_email"
            value="{{ $user->company_email }}"
        >

    </div>

    <div class="form-group col-12 col-md-6">
        <label for="commodity" class="mb-1">Commodities *</label>
        <input
            disabled
            name="commodity"
            id="commodity"
            class="form-control"
            value="{{ $user->commodity }}"
        >
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
            disabled
            id="full_name"
            type="text"
            class="form-control"
            value="{{ $user->full_name }}"
        >

    </div>
    <div class="form-group col-12 col-md-6">
        <label for="salutation" class="mb-1">Salutation </label>
        <input
            disabled
            id="salutation"
            type="text"
            class="form-control"
            name="salutation"
            value="{{ $user->salutation }}"
        >

    </div>
    <div class="form-group col-12 col-md-6">
        <label for="function_in_company" class="mb-1">Function in company *</label>
        <input
            disabled
            id="function_in_company"
            type="text"
            class="form-control"
            name="function_in_company"
            value="{{ $user->function_in_company }}"
        >
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="email_register" class="mb-1">Email *</label>
        <input
            disabled
            id="email_register"
            type="email"
            class="form-control"
            name="email_register"
            value="{{ $user->email }}">
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="platform" class="mb-1">Platform *</label>
        <input
            disabled
            id="platform"
            type="text"
            class="form-control"
            name="platform"
            value="{{ $user->platform }}"
        >

    </div>
    <div class="form-group col-12 col-md-6">
        <label for="mobile_no" class="mb-1">Mobile No *</label>
        <input
            disabled
            id="mobile_no"
            type="text"
            class="form-control"
            name="mobile_no"
            value="{{ $user->mobile_no }}"
        >

    </div>
</div>
