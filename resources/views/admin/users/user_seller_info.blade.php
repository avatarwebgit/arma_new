<div class="form-group col-12 col-md-6">
    <label for="company_name" class="mb-1">Company Name *</label>
    <input disabled id="company_name" type="text" class="form-control" name="company_name" value="{{ $user->company_name }}" required>

</div>
<div class="form-group col-12 col-md-6">
    <label for="company_type" class="mb-1">Company Type *</label>
    <input disabled id="company_type" type="text" class="form-control" name="company_type" value="{{ ucfirst($user->Roles[0]->name) }}" required>

</div>
<div class="form-group col-12 col-md-6">
    <label for="company_country" class="mb-1">Country *</label>
    <select name="company_country" id="company_country" class="form-control @error('company_country') is-invalid @enderror" required>
        <option value="">Select Country</option>
        @foreach($countries as $country)
            <option {{ $user->company_country == $country->countryName ? 'selected' : '' }} value="{{ $country->countryName }}">{{ $country->countryName }}</option>
        @endforeach
    </select>
    @error('company_country')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>
<div class="form-group col-12 col-md-6">
    <label for="company_address" class="mb-1">Address *</label>
    <input name="company_address" id="company_address" class="form-control @error('company_address') is-invalid @enderror" required
           value="{{ $user->company_address }}"
    >
    @error('company_address')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>
<div class="form-group col-12 col-md-6">
    <label for="company_address" class="mb-1">Main Telephone Number *</label>
    <input name="company_phone" id="company_phone" class="form-control @error('company_phone') is-invalid @enderror" required
           value="{{ $user->company_phone }}"
    >
    @error('company_phone')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>
<div class="form-group col-12 col-md-6">
    <label for="company_website" class="mb-1">Website</label>
    <input name="company_website" id="company_website" class="form-control @error('company_website') is-invalid @enderror" required
           value="{{ $user->company_website }}"
    >
    @error('company_website')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>
<div class="form-group col-12 col-md-6">
    <label for="company_email" class="mb-1">Email *</label>
    <input disabled name="company_email" id="company_email" class="form-control @error('company_email') is-invalid @enderror" required
           value="{{ $user->company_email }}"
    >
    @error('company_email')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>
<div class="form-group col-12 col-md-6">
    <label for="commodity" class="mb-1">Commodities *</label>
    <select name="commodity" id="commodity" class="form-control @error('commodity') is-invalid @enderror" required>
        @foreach($commodities as $commodity)
        <option {{ $user->commodity==$commodity->title ? 'selected' : '' }}>{{ $commodity->title }}</option>
        @endforeach
    </select>
    @error('commodity')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>

<div class="form-group col-12 col-md-6">
    <label for="full_name" class="mb-1">Full Name *</label>
    <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror" name="full_name" value="{{ $user->full_name }}" required>
    @error('full_name')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>

<div class="form-group col-12 col-md-6">
    <label for="salutation" class="mb-1">Salutation</label>
    <input id="salutation" type="text" class="form-control
    @error('salutation') is-invalid @enderror"
           name="salutation"
           value="{{ $user->salutation }}" required>
    @error('salutation')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>

<div class="form-group col-12 col-md-6">
    <label for="function_in_company" class="mb-1">Function In Company *</label>
    <input id="function_in_company" type="text" class="form-control
    @error('function_in_company') is-invalid @enderror"
           name="function_in_company"
           value="{{ $user->function_in_company }}" required>
    @error('function_in_company')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>
<div class="form-group col-12 col-md-6">
    <label for="company_email" class="mb-1">Email *</label>
    <input id="company_email" type="text" class="form-control
    @error('company_email') is-invalid @enderror"
           name="company_email"
           value="{{ $user->company_email }}" required>
    @error('company_email')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>
<div class="form-group col-12 col-md-6">
    <label for="platform" class="mb-1">Platform *</label>
    <select name="platform" id="platform" class="form-control @error('platform') is-invalid @enderror" required>
        @foreach($platforms as $platfotm)
            @if($platfotm->id!=4 and $platfotm->id!=5)
                <option {{ $platfotm->title==$user->platform ? 'selected' : '' }} value="{{ $platfotm->title }}">{{ $platfotm->title }}</option>
            @endif
        @endforeach
    </select>



</div>
<div class="form-group col-12 col-md-6">
    <label for="mobile_no" class="mb-1">Mobile No *</label>
    <input name="mobile_no" id="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror" required
           value="{{ $user->mobile_no }}"
    >
    @error('mobile_no')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>

<div class="form-group col-12 col-md-6">
    <label for="join_date" class="mb-1">Join Date</label>
    <input disabled id="join_date" type="date" class="form-control @error('join_date') is-invalid @enderror" name="join_date" value="{{ $user->created_at }}" required>
    @error('join_date')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>
