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

@if(auth()->user()->hasRole('Members'))
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
@endif

<div class="form-group col-12 col-md-6">
    <label for="email" class="mb-1">Email *</label>
    <input disabled id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required>
    @error('email')
    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
    @enderror
</div>

<div class="form-group col-12 col-md-6">
    <label for="role" class="mb-1">Role *</label>
    <select disabled name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
        <option value="">Select Role</option>
        @foreach($roles as $role)
            <option {{ $user->Roles()->first()->id == $role->id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>
    @error('role')
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
