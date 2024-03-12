<footer class="landing-footer-two">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('home.index') }}">
                    <img src="{{ imageExist(env('UPLOAD_SETTING'),$logo) }}" alt="">
                </a>
                <p>
                    {{ $about_arma }}
                </p>
                <ul class="social-icon">
                    <li><a href="/{{ $facebook }}"><i class="icon ion-logo-facebook"></i></a></li>
                    <li><a href="/{{ $twitter }}"><i class="icon ion-logo-twitter"></i></a></li>
                    <li><a href="/{{ $linkedin }}"><i class="icon ion-logo-linkedin"></i></a></li>
                </ul>
            </div>
            @php
                $menus=\App\Models\Menus::where('parent',0)->get();
            @endphp
            @foreach($menus as $menu)
                @if($menu->id!=4)
                    <div class="col-md-2">
                        <h3>
                            <a href="{{ route('home.menus',['menus'=>$menu->id]) }}">
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
        </div>
    </div>
</footer>
