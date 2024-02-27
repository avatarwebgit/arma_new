<header class="dark-bb">
    @include('home.sections.header1')
    @include('home.sections.header2')
    <nav class="navbar navbar-expand-lg">
        <a class='navbar-brand' href='{{ route('home.index') }}'><img class="logo" src="{{ imageExist(env('UPLOAD_SETTING'),$logo) }}" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#headerMenu"
                aria-controls="headerMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="icon ion-md-menu"></i>
        </button>

        <div class="collapse navbar-collapse" id="headerMenu">
            <ul class="navbar-nav d-flex align-items-center">
                @php
                    $menus=\App\Models\Menus::where('parent',0)->get();
                @endphp
                @foreach($menus as $menu)
                    @if($menu->id==2)
                        <li class="nav-item d-flex align-items-center mr-3">
                            <a class="nav-link" href="{{ route('home.menus',['menus'=>$menu->id]) }}"
                               aria-haspopup="true"
                               aria-expanded="false">
                                {{ $menu->title }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown d-flex align-items-center mr-3">
                            <a class="nav-link dropdown-toggle" href="{{ route('home.menus',['menus'=>$menu->id]) }}" data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false">
                                {{ $menu->title }}
                            </a>
                            @if(count($menu->children)>0)
                                <div class="dropdown-menu">
                                    @foreach($menu->children as $child)
                                        <a class='dropdown-item' href='{{ route('home.menus',['menus'=>$child->id]) }}'>
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </li>
                    @endif

                @endforeach
            </ul>
            <ul class="navbar-nav ml-auto d-flex align-items-center search_and_btns">
                <li class="nav-item header-custom-icon position-relative mr-5">
                    <input class="form-control form-control-sm" placeholder="search...">
                    <i class="icon ion-md-search position-absolute" style="top: 4px;right: 10px"></i>
                </li>
                <li title="login" class="login_btn">
                    <a class="nav-link" href="{{ route('login') }}">
                        login
                    </a>
                </li>
                <li title="Register" class="login_btn ml-3">
                    <a class="nav-link" href="{{ route('register') }}">
                        Register
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
