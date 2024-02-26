@extends('home.homelayout.app')

@section('script')

@endsection

@section('content')

    <div class="landing-feature">
        <div class="container">
            @if($page!=null)
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{ $page->title }}</h2>
                    </div>
                    <div class="col-md-12">
                        {!! $page->description !!}
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('home.partials.footer')

@endsection
