<header class="dark-bb">
    @include('home.sections.header1')
    @include('home.sections.header2')
    <nav class="navbar navbar-expand-lg">
        <div class="col-2 col-2 d-flex justify-content-center">
            <a class='navbar-brand' href='{{ route('home.index') }}'><img class="logo" src="{{ imageExist(env('UPLOAD_SETTING'),$logo) }}" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#headerMenu"
                    aria-controls="headerMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="icon ion-md-menu"></i>
            </button>
        </div>
        <div class="col-8 col-2 d-flex">
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
        </div>
        <div class="col-2 d-flex justify-content-center">
            <ul class="navbar-nav d-flex align-items-center">
                <li title="login" class="nav-item dropdown header-img-icon d-flex">
                    <a style="font-size: 22px;color: #000 !important;" class="nav-link" href="">
                        <i class="fa fa-search" style="color: #006 !important;"></i>
                    </a>
                </li>
                @auth
                    <li class="nav-item dropdown header-img-icon">
                        <a style="font-size: 22px;color: #000 !important;"class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            <i class="fa fa-sign-out" style="color: #006 !important;"></i>
                        </a>
                        <div class="dropdown-menu">
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
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    @elseif(auth()->user()->hasRole('buyer'))
                                        <p class="email text-muted mb-3">Buyer</p>
                                        <a href="{{ route('profile') }}">profile</a>
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
                                        <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" class='nav-link red' href='{{ route('logout') }}'>
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
                    <li title="login" class="nav-item dropdown header-img-icon d-flex">
                        <a style="font-size: 22px;color: #000 !important;" class="nav-link" href="{{ route('login') }}">
                            <i class="fa fa-user"></i>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>


{{--        <div class="collapse navbar-collapse" id="headerMenu">--}}
{{--            --}}
{{--           --}}
{{--        </div>--}}
    </nav>
</header>
