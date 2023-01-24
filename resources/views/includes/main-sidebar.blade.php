<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper"><a href="{{url('')}}"><img class="img-fluid for-light" src="{{ asset('/theme/cuba/assets/images/logo/logo.png') }}" alt=""><img class="img-fluid for-dark" src="{{ asset('/theme/cuba/assets/images/logo/logo_dark.png') }}" alt=""></a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{url('')}}"><img class="img-fluid" src="{{ asset('/theme/cuba/assets/images/logo/logo-icon.png') }}" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="#"><img class="img-fluid" src="{{ asset('/theme/cuba/assets/images/logo/logo-icon.png') }}" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{url('home')}}">
                            <i data-feather="home"></i><span>Home</span>
                        </a>
                    </li>
                    @foreach($header_menu_sidebar as $v_header)
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="mb-0">{{ $v_header }}</h6>
                        </div>
                    </li>
                    @foreach($menu_sidebar['menus'] as $v_menu)
                        @if($v_header==$v_menu['menu_header'])
                            @if(!empty($v_menu['menu_name']) && $v_menu['link'] == "#")

                                @if($v_menu['sub']['submenu'])
                                <li class="sidebar-list {{$v_menu['active']}}">
                                    <a class="sidebar-link sidebar-title" href="#">
                                        <i data-feather="{{ $v_menu['icon'] }}"></i>
                                        <span>{{ __($v_menu['menu_name']) }}</span>
                                    </a>
                                    <ul class="sidebar-submenu">
                                        @foreach($v_menu['sub']['submenu'] as $submn)
                                            @if($submn)
                                                <li class="{{$submn['sub_active']}}">
                                                    <a href="{{url($submn['link'])}}">{{ __($submn['menu_name']) }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif

                            @else
                            <li class="sidebar-list {{ ($link==$v_menu['link']) ? 'menu-item-active' : ''}}">
                                <a class="sidebar-link sidebar-title link-nav" href="{{ url($v_menu['link']) }}">
                                    <i data-feather="{{ $v_menu['icon'] }}"> </i><span>{{ __($v_menu['menu_name']) }}</span>
                                </a>
                            </li>
                            @endif
                        @endif
                    @endforeach
                    @endforeach
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>