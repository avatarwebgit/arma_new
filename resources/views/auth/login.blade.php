@extends('home.homelayout.app')

@section('content')
    <div class="row">
        <div class="col-12 col-md-4 border-1 m-auto pt-5 pb-5">
            <form method="POST" action="{{ route('login') }}" class="p-5" style="border: 1px solid black;border-radius: 5px;background-color: #f8f8f8">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center">Sign In</h3>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-12">
                        <label for="email">Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               placeholder="{{ __('Email Address') }}"
                               required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="form-group col-12">
                        <label for="password">Password</label>
                        <input
                            id="password"
                            type="password"
                            placeholder="{{ __('Password') }}"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            required
                            autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    @if (Route::has('password.request'))
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <button type="submit" class="btn btn-primary">{{ __('Log In') }}</button>
                        <div class="text-right">
                            <a href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection

