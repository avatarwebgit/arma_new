<header >
    @include('home.sections.header1')
    @include('home.sections.header2')
    <nav class="navbar navbar-expand-lg menu-desktop">
{{--        //logo--}}
        <div style="width: 10%;text-align: center">
            <a class='navbar-brand' href='{{ route('home.index') }}'><img class="logo"
                                                                          src="{{ imageExist(env('UPLOAD_SETTING'),$logo) }}"
                                                                          alt="logo"></a>
        </div>
{{--        //menu--}}
        <div style="width: 55%;">

            <ul class="navbar-nav d-flex ">
                @php
                    $menus=\App\Models\Menus::where('parent',0)->where('show_on_header',1)->get();
                @endphp
                @foreach($menus as $menu)
                    @if($menu->id==2)
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link" href="{{ route('home.menus',['menus'=>$menu->id]) }}"
                               aria-haspopup="true"
                               aria-expanded="false">
                                {{ $menu->title }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown d-flex align-items-center mr-3">
                            <a class="nav-link dropdown-toggle" href="{{ route('home.menus',['menus'=>$menu->id]) }}"
                               data-toggle="dropdown"
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
        </div>
{{--        //search--}}
        <div style="width: 25%;">
            <ul class="navbar-nav ml-auto d-flex align-items-center search_and_btns">
                <li class="nav-item header-custom-icon position-relative mr-2" style="width: 100%">
                    <input class="form-control form-control-sm" placeholder="search...">
                    <i class="icon ion-md-search position-absolute" style="top: 4px;right: 10px"></i>
                </li>

            </ul>
        </div>
{{--        //menu--}}
        <div style="width: 10%">
            @auth
                <li class="nav-item dropdown header-img-icon d-flex justify-content-center">
                    <a style="padding:0 !important; " class="nav-link dropdown-toggle mr-2" href="#" role="button" data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        <img src="{{ asset('home/img/avatar.svg') }}" alt="avatar">
                    </a>
                    <p class="mt-1 pr-4">hi ,{{ auth()->user()->full_name }}</p>
                    <div class="dropdown-menu profile" style="left: -130px !important;">
                        <div class="dropdown-header d-flex flex-column align-items-center">
                            <div class="figure mb-3">
                                <img src="{{ asset('home/img/avatar.svg') }}" alt="">
                            </div>
                            <div class="info text-center">
                                <p class="name font-weight-bold mb-0">{{ auth()->user()->name }}</p>
                                <p class="email text-muted mb-3">{{ auth()->user()->email }}</p>
                                @if(auth()->user()->hasRole('admin'))
                                    <p class="email text-muted mb-3">Admin</p>
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                @elseif(auth()->user()->hasRole('seller'))
                                    <p class="email text-muted mb-3">Seller</p>
                                    <a href="{{ route('seller.dashboard') }}">Dashboard</a>
                                @elseif(auth()->user()->hasRole('buyer'))
                                    <p class="email text-muted mb-3">Buyer</p>
                                    <a href="{{ route('bidder.dashboard') }}">Dashboard</a>
                                @endif
                            </div>
                        </div>
                        <div class="dropdown-body">
                            <ul class="profile-nav">
                                {{--                                    <li class="nav-item">--}}
                                {{--                                        <a class='nav-link' href='{{ route('profile') }}'>--}}
                                {{--                                            <i class="icon ion-md-person"></i>--}}
                                {{--                                            <span>Profile</span>--}}
                                {{--                                        </a>--}}
                                {{--                                    </li>--}}

                                {{--                                    <li class="nav-item">--}}
                                {{--                                        <a class='nav-link' href='{{ route('admin.dashboard') }}'>--}}
                                {{--                                            <i class="icon ion-md-person"></i>--}}
                                {{--                                            <span>Admin Panel</span>--}}
                                {{--                                        </a>--}}
                                {{--                                    </li>--}}

                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a class='nav-link' href='settings-wallet-dark.html'>--}}
                                {{--                                        <i class="icon ion-md-wallet"></i>--}}
                                {{--                                        <span>My Wallet</span>--}}
                                {{--                                    </a>--}}
                                {{--                                </li>--}}
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a class='nav-link' href='settings-dark.html'>--}}
                                {{--                                        <i class="icon ion-md-settings"></i>--}}
                                {{--                                        <span>Settings</span>--}}
                                {{--                                    </a>--}}
                                {{--                                </li>--}}
                                {{--                                <li class="nav-item" id="changeThemeDark">--}}
                                {{--                                    <a href="#!" class="nav-link">--}}
                                {{--                                        <i class="icon ion-md-moon"></i>--}}
                                {{--                                        <span>Theme</span>--}}
                                {{--                                    </a>--}}
                                {{--                                </li>--}}
                                <li class="nav-item">
                                    <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                       class='nav-link red' href='{{ route('logout') }}'>
                                        <i class="icon ion-md-power"></i>
                                        <span>Log Out</span>
                                    </a>
                                    {!! Form::open([
                        'route' => ['logout'],
                        'method' => 'POST',
                        'id' => 'logout-form',
                        'class' => 'd-none',
                    ]) !!}
                                    {!! Form::close() !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            @else
                <ul style="margin-left: auto" class="d-flex justify-content-center">
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
            @endauth
        </div>
    </nav>
{{--    //mobile Menu--}}
    <nav class="navbar mobile-menu">
    <button onclick="ShowMenu()" class="navbar-toggler" type="button"  aria-label="Toggle navigation">
        <i class="icon ion-md-menu"></i>
    </button>
    <div class="mobile-nav">
        <div class="d-flex align-items-center">
            <img class="logo"
                 src="{{ imageExist(env('UPLOAD_SETTING'),$logo) }}"
                 alt="logo">
            <i onclick="CloseMenu()" class="fa fa-times-circle fa-2x cursor-pointer" style="position: absolute;top: 20px;right: 20px"></i>

        </div>
        <div class="mt-2 mb-2">
            <ul style="margin-left: auto" class="d-flex justify-content-center">
                <li style="width: 50%" title="login" class="login_btn">
                    <a class="nav-link text-center" href="{{ route('login') }}">
                        login
                    </a>
                </li>
                <li style="width: 50%" title="Register" class="login_btn ml-3">
                    <a class="nav-link text-center" href="{{ route('register') }}">
                        Register
                    </a>
                </li>
            </ul>
        </div>
        <div class="mt-2 mb-2 position-relative">
            <input class="form-control form-control-sm" placeholder="search...">
            <i class="icon ion-md-search position-absolute" style="top: 4px;right: 10px"></i>
        </div>
        <div>

            <ul class="navbar-nav d-flex ">
                @php
                    $menus=\App\Models\Menus::where('parent',0)->get();
                @endphp
                @foreach($menus as $menu)
                    @if($menu->id==2)
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link" href="{{ route('home.menus',['menus'=>$menu->id]) }}"
                               aria-haspopup="true"
                               aria-expanded="false">
                                {{ $menu->title }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown d-flex align-items-center mr-3">
                            <a class="nav-link dropdown-toggle" href="{{ route('home.menus',['menus'=>$menu->id]) }}"
                               data-toggle="dropdown"
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
        </div>
    </div>
    </nav>
</header>
