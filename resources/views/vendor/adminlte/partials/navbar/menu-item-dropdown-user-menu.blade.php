@php($logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout'))
@php($profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'profile'))

@if (config('adminlte.usermenu_profile_url', false))
    @php($profile_url = Auth::user()->adminlte_profile_url())
@endif

@if (config('adminlte.use_route_url', false))
    @php($profile_url = $profile_url ? route($profile_url) : '')
    @php($logout_url = $logout_url ? route($logout_url) : '')
@else
    @php($profile_url = $profile_url ? url($profile_url) : '')
    @php($logout_url = $logout_url ? url($logout_url) : '')
@endif

<li class="nav-item dropdown user-menu">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        @if (config('adminlte.usermenu_image'))
            <img src="https://portal.um.edu.my/ihris/gambar_staff/{{ auth()->user()->profile->salary_no }}.jpg"
                class="user-image img-circle elevation-2" alt="" onerror="this.onerror=null; this.src='{{ asset('img/avatar.png') }}'">
        @endif
        <span @if (config('adminlte.usermenu_image')) class="d-none d-md-inline" @endif>
            {{ isset(Auth::user()->name) ? Auth::user()->name : Cas::getUser() }}
        </span>
    </a>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

        {{-- User menu header --}}
        @if (!View::hasSection('usermenu_header') && config('adminlte.usermenu_header'))
            <li
                class="user-header {{ config('adminlte.usermenu_header_class', 'bg-primary') }} @if (!config('adminlte.usermenu_image')) h-auto @endif">
                @if (config('adminlte.usermenu_image'))
                    <img src="https://portal.um.edu.my/ihris/gambar_staff/{{ auth()->user()->profile->salary_no }}.jpg"
                        class="img-circle elevation-2" alt="{{ Auth::user()->name }}" onerror="this.onerror=null; this.src='{{ asset('img/avatar.png') }}'">
                @endif
                <p class="@if (!config('adminlte.usermenu_image')) mt-0 @endif">
                    {{ isset(Auth::user()->name) ? Auth::user()->name : Cas::getUser() }}
                    @if (config('adminlte.usermenu_desc'))
                        <small>{{ isset(Auth::user()->email) ? Auth::user()->email : Cas::getUser() }}</small>
                    @endif

                    @if (config('adminlte.userrole_desc'))
                        <small>{{ __('Role') }} :
                            <b>{{ implode(', ',auth()->user()->getRoleNames()->toArray()) }}</b></small>
                    @endif
                </p>
            </li>
        @else
            @yield('usermenu_header')
        @endif

        {{-- Configured user menu links --}}
        @each('adminlte::partials.navbar.dropdown-item', $adminlte->menu("navbar-user"), 'item')

        {{-- User menu body --}}
        @hasSection('usermenu_body')
            <li class="user-body">
                @yield('usermenu_body')
            </li>
        @endif

        {{-- User menu footer --}}
        <li class="user-footer">
            @if ($profile_url)
                <a href="{{ $profile_url }}" class="btn btn-default btn-flat">
                    <i class="fa fa-fw fa-user"></i>
                    {{ __('Profile') }}
                </a>
            @endif
            @if (session()->has('ori_user_id'))
                <a href="{{ route('site.users.logged-as.logout') }}"
                    class="btn btn-danger btn-flat float-right @if (!$profile_url) btn-block @endif">
                    <i class="fa fa-fw fa-power-off"></i> {{ __('End Logged As') }}
                </a>
            @else
                <a class="btn btn-danger btn-flat float-right @if (!$profile_url) btn-block @endif"
                    href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-fw fa-power-off"></i> {{ __('Sign out') }}
                </a>

                <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                    @if (config('adminlte.logout_method'))
                        {{ method_field(config('adminlte.logout_method')) }}
                    @endif
                    {{ csrf_field() }}
                </form>
            @endif

        </li>

    </ul>

</li>
