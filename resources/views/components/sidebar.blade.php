<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Resto Ramski</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">RR</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('home') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('home') }}">Dashboard</a>
                    </li>
                </ul>
            </li>
            @auth
                @if (auth()->user()->role === 'admin')
                    <li class="{{ Request::is('users') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ route('users.index') }}"><i class="fas fa-user-circle"></i> <span>Users</span></a>
                    </li>
                @endif
            @endauth
        </ul>

        {{-- <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs"
                class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div> --}}
    </aside>
</div>
