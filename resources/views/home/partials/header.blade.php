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
            <ul class="navbar-nav mr-auto d-flex align-items-center">
                @php
                $menus=\App\Models\Menus::where('parent',0)->get();
                @endphp
                @foreach($menus as $menu)
                <li class="nav-item dropdown d-flex align-items-center mr-3">
                    <a class="nav-link" href="{{ route('home.menus',['menus'=>$menu->id]) }}"
                       aria-haspopup="true"
                       aria-expanded="false">
                        {{ $menu->title }}
                    </a>
                    <span class="dropdown-toggle cursor-pointer" role="button" data-toggle="dropdown">
                            <i class="fa-angle-down"></i>
                        </span>
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
                @endforeach
            </ul>
            <ul class="navbar-nav ml-auto d-flex align-items-center">
                {{--                <li class="nav-item header-custom-icon">--}}
                {{--                    <a class="nav-link" href="#" id="clickFullscreen">--}}
                {{--                        <i class="icon ion-md-expand"></i>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
                {{--                <li class="nav-item dropdown header-custom-icon">--}}
                {{--                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"--}}
                {{--                       aria-haspopup="true"--}}
                {{--                       aria-expanded="false">--}}
                {{--                        <i class="icon ion-md-notifications"></i>--}}
                {{--                        <span class="circle-pulse"></span>--}}
                {{--                    </a>--}}
                {{--                    <div class="dropdown-menu">--}}
                {{--                        <div class="dropdown-header d-flex align-items-center justify-content-between">--}}
                {{--                            <p class="mb-0 font-weight-medium">6 New Notifications</p>--}}
                {{--                            <a href="#!" class="text-muted">Clear all</a>--}}
                {{--                        </div>--}}
                {{--                        <div class="dropdown-body">--}}
                {{--                            <a href="#!" class="dropdown-item">--}}
                {{--                                <div class="icon">--}}
                {{--                                    <i class="icon ion-md-lock"></i>--}}
                {{--                                </div>--}}
                {{--                                <div class="content">--}}
                {{--                                    <p>Account password change</p>--}}
                {{--                                    <p class="sub-text text-muted">5 sec ago</p>--}}
                {{--                                </div>--}}
                {{--                            </a>--}}
                {{--                            <a href="#!" class="dropdown-item">--}}
                {{--                                <div class="icon">--}}
                {{--                                    <i class="icon ion-md-alert"></i>--}}
                {{--                                </div>--}}
                {{--                                <div class="content">--}}
                {{--                                    <p>Solve the security issue</p>--}}
                {{--                                    <p class="sub-text text-muted">10 min ago</p>--}}
                {{--                                </div>--}}
                {{--                            </a>--}}
                {{--                            <a href="#!" class="dropdown-item">--}}
                {{--                                <div class="icon">--}}
                {{--                                    <i class="icon ion-logo-android"></i>--}}
                {{--                                </div>--}}
                {{--                                <div class="content">--}}
                {{--                                    <p>Download android app</p>--}}
                {{--                                    <p class="sub-text text-muted">1 hrs ago</p>--}}
                {{--                                </div>--}}
                {{--                            </a>--}}
                {{--                            <a href="#!" class="dropdown-item">--}}
                {{--                                <div class="icon">--}}
                {{--                                    <i class="icon ion-logo-bitcoin"></i>--}}
                {{--                                </div>--}}
                {{--                                <div class="content">--}}
                {{--                                    <p>Bitcoin price is high now</p>--}}
                {{--                                    <p class="sub-text text-muted">2 hrs ago</p>--}}
                {{--                                </div>--}}
                {{--                            </a>--}}
                {{--                            <a href="#!" class="dropdown-item">--}}
                {{--                                <div class="icon">--}}
                {{--                                    <i class="icon ion-logo-usd"></i>--}}
                {{--                                </div>--}}
                {{--                                <div class="content">--}}
                {{--                                    <p>Payment completed</p>--}}
                {{--                                    <p class="sub-text text-muted">4 hrs ago</p>--}}
                {{--                                </div>--}}
                {{--                            </a>--}}
                {{--                        </div>--}}
                {{--                        <div class="dropdown-footer d-flex align-items-center justify-content-center">--}}
                {{--                            <a href="#!">View all</a>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </li>--}}


                @auth
                    <li class="nav-item dropdown header-img-icon">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            <img src="{{ asset('home/img/avatar.svg') }}" alt="avatar">
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
                    <li class="nav-item dropdown header-img-icon d-flex">
                        <a style="font-size: 22px;color: #000 !important;" class="nav-link" href="{{ route('login') }}">
                            Login
                        </a>
                        <a style="font-size: 22px;margin-left: 10px;color:#007bff !important;" class="nav-link " href="{{ route('register') }}">
                            Register
                        </a>

                    </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>
