@extends('home.homelayout.app')

@section('content')
    <div class="row mb-5">
        <div class="col-12 col-md-4 border-1 m-auto pt-5 pb-5">
            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center">Sign In</h3>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-12">
                        <label for="email">Username (Email)</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
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
                            <button type="submit" class="btn btn-primary" style="padding: 5px 20px">{{ __('Log In') }}</button>

                            <div class="text-right text-white">
                                <a href="{{ route('password.request') }}" style="color: white !important;">
                                    {{ __('Forgot Password?') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="col-12 d-flex justify-content-start mt-2 align-items-center">
                        <div class="text-left">

                            <a class="text-white" href="{{ route('register') }}">
                                Don`t have an account ? <span>Register now</span>
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

