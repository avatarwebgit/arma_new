@extends('home.homelayout.app')

@section('content')
    <div class="row">
        <div class="col-12 col-md-4 border-1 m-auto pt-5 pb-5">
            <form method="POST" action="{{ route('password.email') }}" class="p-5" style="border: 1px solid black;border-radius: 5px;background-color: #f8f8f8">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center">Reset Password</h3>
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-12">
                        <label for="email">Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               placeholder="{{ __('Enter email address') }}"
                               required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                        <a href="{{ route('login') }}" class="btn btn-dark">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
