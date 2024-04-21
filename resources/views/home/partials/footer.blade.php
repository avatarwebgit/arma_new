<footer  class="landing-footer-two mt-3">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-5">
                <form method="post" action="{{route('join.news')}}" >
                    @csrf
                    @method('POST')
                    <div class="input-group">
                        <input placeholder="example@gmail.com ..." aria-describedby="button-addon2" type="text" name="email" class="form-control">
                        <button class="btn btn-warning ml-3" type="submit" id="button-addon2">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">

            @php
                $menus=\App\Models\Menus::where('parent',0)->get();
            @endphp
            @foreach($menus as $menu)
                @if($menu->id!=4)
                    <div class="col-md-2">
                        <h3 class="mb-5 fw-bold">
                            <a class="text-white" href="{{ route('home.menus',['menus'=>$menu->id]) }}">
                                {{ $menu->title }}
                            </a>
                        </h3>
                        <ul>
                            @foreach($menu->children as $child)
                                <li><a href="{{ route('home.menus',['menus'=>$child->id]) }}">
                                        {{ $child->title }}
                                    </a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach
            <div class="col-md-2">
                <h3 class="text-white mb-5">
                    FOLLOW US
                </h3>
                <ul class="social-icon">
                    <li class="icon-social-media"><a href="/{{ $facebook }}"><i class="icon ion-logo-facebook"></i></a></li>
                    <li class="icon-social-media"><a href="/{{ $twitter }}"><i class="icon ion-logo-twitter"></i></a></li>
                    <li class="icon-social-media"><a href="/{{ $linkedin }}"><i class="icon ion-logo-linkedin"></i></a></li>
                </ul>
            </div>
            <div class="row mb-2">
                <div class="col-md-11">

                    <p>
                        {{ $about_arma }}
                    </p>

                </div>

                <div class="col-md-1">
                    <a href="{{ route('home.index') }}">
                        <img src="{{ imageExist(env('UPLOAD_SETTING'),$footer_logo) }}" alt="">
                    </a>
                </div>
            </div>
            <div class="col-md-12 mt-5">
                <div class="d-flex flex-column align-items-start  justify-content-between">
                    <span class="text-white text-muted">
                        {{ $copy_right }}
                    </span>
                </div>
            </div>

        </div>
        <a href="javascript:void(0)" class="js-lcc-settings-toggle">@lang('cookie-consent::texts.alert_settings')</a>
    </div>
</footer>
