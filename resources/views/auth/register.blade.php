@extends('home.homelayout.app')

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 border-1 m-auto pt-5 pb-5">
            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center">Registery</h3>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-12 col-md-6">
                        <label for="commodity" class="mb-1">Commodities *</label>
                        <select name="commodity" id="commodity" class="form-control">
                            <option value="">Select Commodity</option>
                            @foreach($commodities as $commodity)
                                <option {{ old('commodity')==$commodity->id ? 'selected' : ''  }} value="{{ $commodity->id }}">
                                    {{ $commodity->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('commodity')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_name" class="mb-1">Company Name *</label>
                        <input
                            id="company_name"
                            type="text"
                            class="form-control @error('company_name') is-invalid @enderror"
                            name="company_name"
                            value="{{ old('company_name') }}" required>
                        @error('company_name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
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
                            id="company_address"
                            type="text"
                            class="form-control @error('company_address') is-invalid @enderror"
                            name="company_address"
                            value="{{ old('company_address') }}" required>

                        @error('company_address')
                        <span class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_post_zip_code" class="mb-1">post/zip code *</label>
                        <input
                            id="company_post_zip_code"
                            type="text"
                            class="form-control @error('company_post_zip_code') is-invalid @enderror"
                            name="company_post_zip_code"
                            value="{{ old('company_post_zip_code') }}" required>

                        @error('company_post_zip_code')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_city" class="mb-1">company city</label>
                        <input
                            id="company_city"
                            type="text"
                            class="form-control @error('company_city') is-invalid @enderror"
                            name="company_city"
                            value="{{ old('company_city') }}">

                        @error('company_city')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_state" class="mb-1">State (US entities only)</label>
                        <input
                            id="company_state"
                            type="text"
                            class="form-control @error('company_state') is-invalid @enderror"
                            name="company_state"
                            value="{{ old('company_state') }}">
                        @error('company_state')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_country" class="mb-1">Select Country</label>
                        <select name="company_country" id="company_country" class="form-control">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option {{ old('company_country')==$country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->title }}</option>
                            @endforeach
                        </select>
                        @error('company_country')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
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
                            id="company_phone"
                            type="text"
                            class="form-control @error('company_phone') is-invalid @enderror"
                            name="company_phone"
                            value="{{ old('company_phone') }}" required>

                        @error('company_phone')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_website" class="mb-1">Website</label>
                        <input
                            id="company_website"
                            type="text"
                            class="form-control @error('company_website') is-invalid @enderror"
                            name="company_website"
                            value="{{ old('company_website') }}" required>

                        @error('company_website')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_email" class="mb-1">Email</label>
                        <input
                            id="company_email"
                            type="email"
                            class="form-control @error('company_email') is-invalid @enderror"
                            name="company_email"
                            value="{{ old('company_email') }}" required>

                        @error('company_email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
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
                            id="user_type"
                            type="text"
                            class="form-control @error('user_type') is-invalid @enderror"
                            name="user_type">
                            <option value="">Select User Type</option>
                            @foreach($types as $type)
                                <option {{ old('type')==$type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>

                        @error('user_type')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="salutation" class="mb-1">Salutation *</label>
                        <select id="salutation"
                            type="text"
                            class="form-control @error('salutation') is-invalid @enderror"
                                name="salutation">
                            <option value="">Select</option>
                            @foreach($salutation as $item)
                                <option {{ old('salutation')==$item->id  ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        @error('salutation')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="full_name" class="mb-1">Full Name *</label>
                        <input
                            id="full_name"
                            type="text"
                            class="form-control @error('full_name') is-invalid @enderror"
                            name="full_name"
                        value="{{ old('full_name') }}"
                            required
                        >
                        @error('full_name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="company_title" class="mb-1">Company Title *</label>
                        <input
                            id="company_title"
                            type="text"
                            class="form-control @error('company_title') is-invalid @enderror"
                            name="company_title"
                            value="{{ old('company_title') }}"
                            required
                        >
                        @error('company_title')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="function_in_company" class="mb-1">Function in company</label>
                        <select
                            id="function_in_company"
                            type="text"
                            class="form-control @error('function_in_company') is-invalid @enderror"
                            name="function_in_company">
                            <option value="">Select</option>
                            @foreach($companyFunction as $item)
                                <option {{ old('function_in_company')==$item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>

                        @error('function_in_company')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="email" class="mb-1">Email *</label>
                        <input
                            id="email"
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ old('email') }}"
                            required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="skype" class="mb-1">Skype</label>
                        <input id="skype"
                            type="text"
                            class="form-control @error('skype') is-invalid @enderror"
                            name="skype" value="{{ old('skype') }}">
                        @error('skype')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="whatsapp" class="mb-1">whatsapp</label>
                        <input
                            id="whatsapp"
                            type="text"
                            class="form-control @error('whatsapp') is-invalid @enderror"
                            name="whatsapp" value="{{ old('whatsapp') }}">
                        @error('whatsapp')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <div class="custom-control custom-checkbox">
                            <input {{ old('accept_term') ? 'checked' : '' }} type="checkbox" name="accept_term" id="accept_term"
                                   class="custom-control-input">
                            <label class="custom-control-label" for="accept_term">
                                I accept the
                                <a href="{{ route('home.menus',['menus'=>16]) }}">
                                    Term and Conditions
                                </a>
                            </label>
                            @error('accept_term')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>

                {!! NoCaptcha::renderJs() !!}
                {!! NoCaptcha::display() !!}


                <div class="row">
                    <div class="col-12 col-md-4">
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

