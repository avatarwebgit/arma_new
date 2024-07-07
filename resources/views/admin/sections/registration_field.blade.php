<div class="row">
    <div class="form-group col-12 col-md-6">
        <label for="commodity" class="mb-1">Commodities *</label>
        <select disabled name="commodity" id="commodity" class="form-control">
            <option value="">Select Commodity</option>
            @foreach($commodities as $commodity)
                <option {{ $user->commodity==$commodity->id ? 'selected' : ''  }} value="{{ $commodity->id }}">
                    {{ $commodity->title }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_name" class="mb-1">Company Name *</label>
        <input
            disabled
            id="company_name"
            type="text"
            class="form-control"
            name="company_name"
            value="{{ $user->company_name }}">
    </div>
</div>
<div class="row">
    <div class="col-12">
        <h5 class="mt-3  text-center">
            Company Address
            <hr>
        </h5>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_address" class="mb-1">address *</label>
        <input
            disabled
            id="company_address"
            type="text"
            class="form-control"
            name="company_address"
            value="{{ $user->company_address }}">
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_post_zip_code" class="mb-1">post/zip code *</label>
        <input
            disabled
            id="company_post_zip_code"
            type="text"
            class="form-control"
            name="company_post_zip_code"
            value="{{ $user->company_post_zip_code }}" required>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_city" class="mb-1">company city</label>
        <input
            disabled
            id="company_city"
            type="text"
            class="form-control"
            name="company_city"
            value="{{ $user->company_city }}">
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_state" class="mb-1">State (US entities only)</label>
        <input
            disabled
            id="company_state"
            type="text"
            class="form-control"
            name="company_state"
            value="{{ $user->company_state }}">
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_country" class="mb-1">Select Country</label>
        <select disabled name="company_country" id="company_country" class="form-control">
            <option value="">Select Country</option>
            @foreach($countries as $country)
                <option
                    {{ $user->company_country==$country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->title }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <h5 class="mt-3 text-center">
            Company Contact
            <hr>
        </h5>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_phone" class="mb-1">Main Telephone Number *</label>
        <input
            disabled
            id="company_phone"
            type="text"
            class="form-control"
            name="company_phone"
            value="{{ $user->company_phone }}" required>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_website" class="mb-1">Website</label>
        <input
            disabled
            id="company_website"
            type="text"
            class="form-control"
            name="company_website"
            value="{{ $user->company_website }}" required>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_email" class="mb-1">Email</label>
        <input
            disabled
            id="company_email"
            type="email"
            class="form-control"
            name="company_email"
            value="{{ $user->company_email }}" required>
    </div>

</div>
<div class="row">
    <div class="col-12">
        <h5 class="text-center">
            Master User Details
            <hr>
        </h5>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="user_type" class="mb-1">User Type *</label>
        <select
            disabled
            id="user_type"
            type="text"
            class="form-control"
            name="user_type">
            <option value="">Select User Type</option>
            @foreach($types as $type)
                <option
                    {{ $user->type==$type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="salutation" class="mb-1">Salutation *</label>
        <select disabled id="salutation"
                type="text"
                class="form-control @error('salutation') is-invalid @enderror"
                name="salutation">
            <option value="">Select</option>
            @foreach($salutation as $item)
                <option
                    {{ $user->salutation==$item->id  ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="full_name" class="mb-1">Full Name *</label>
        <input
            disabled
            id="full_name"
            type="text"
            class="form-control"
            name="full_name"
            value="{{ $user->full_name }}"
        >
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="company_title" class="mb-1">Company Title *</label>
        <input
            disabled
            id="company_title"
            type="text"
            class="form-control"
            name="company_title"
            value="{{ $user->company_title }}"
        >
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="function_in_company" class="mb-1">Function in company</label>
        <select
            disabled
            id="function_in_company"
            type="text"
            class="form-control @error('function_in_company') is-invalid @enderror"
            name="function_in_company">
            <option value="">Select</option>
            @foreach($companyFunction as $item)
                <option
                    {{ $user->function_in_company==$item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="email" class="mb-1">Email *</label>
        <input
            disabled
            id="email"
            type="email"
            class="form-control"
            name="email"
            value="{{ $user->email }}">
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="skype" class="mb-1">Skype</label>
        <input
            disabled
            id="skype"
               type="text"
               class="form-control"
               name="skype" value="{{ $user->skype }}">
    </div>
    <div class="form-group col-12 col-md-6">
        <label for="whatsapp" class="mb-1">whatsapp</label>
        <input
            disabled
            id="whatsapp"
            type="text"
            class="form-control"
            name="whatsapp" value="{{ $user->whatsapp }}">
    </div>
</div>
