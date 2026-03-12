@php
    $usr = Auth::guard('web')->user();
@endphp

<nav class="pcoded-navbar menu-light">
    <div class="navbar-wrapper ">
        <div class="navbar-content scroll-div ">
            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption">
                    <label>Menu</label>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-home"></i></span><span class="pcoded-mtext">Welcome</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.officers') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-bar-chart-2"></i></span><span class="pcoded-mtext">Officers
                            Analysis</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.soldiers') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-bar-chart-2"></i></span><span class="pcoded-mtext">Soldiers
                            Analysis</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.ratings') }}" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-bar-chart-2"></i></span><span class="pcoded-mtext">Ratings
                            Analysis</span></a>
                </li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-list"></i></span><span
                                class="pcoded-mtext">Records</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('record-manager') }}">Records Manager</a></li>
                        <li><a href="{{ route('create-record') }}"> Add New</a></li>
                        {{-- @can('superadmin.view')
                            <li><a href="{{ route('view-record') }}"> All Records</a></li>
                            <li><a href="{{ route('mission-pending') }}">Standby(Pending)</a></li>
                            <li><a href="{{ route('approve-personnel') }}">Pending Departure</a></li>
                            <li><a href="{{ route('on-mission') }}">Travelled</a></li>
                            <li><a href="{{ route('course.arrived') }}">Retuned</a></li>
                        @endcan --}}
                    </ul>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i
                                class="feather icon-pie-chart"></i></span><span class="pcoded-mtext">Generate
                                Report</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('system-report') }}">Master Filter</a></li>

                    </ul>
                </li>
                @can('superadmin.view')
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-plus"></i></span><span
                                    class="pcoded-mtext">Mechanizations</span></a>
                        <ul class="pcoded-submenu">
                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{ route('personal-view') }}" class="nav-link "><span
                                        class="pcoded-mtext">Personnel</span></a>
                            </li>

                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{ route('view-unit') }}" class="nav-link "><span
                                        class="pcoded-mtext">Unit</span></a>
                            </li>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{ route('view-rank') }}" class="nav-link "><span
                                        class="pcoded-mtext">Ranks</span></a>
                            </li>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="{{ route('arm-view') }}" class="nav-link "><span class="pcoded-mtext">Arm
                                        of Service</span></a>
                            </li>
                        </ul>
                    </li>
                @endcan

                @can('superadmin.view')
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#!" class="nav-link"><span class="pcoded-micon"><i
                                    class="feather icon-settings"></i></span><span class="pcoded-mtext">
                                    Setting</span></a>
                        <ul class="pcoded-submenu">
                            <li class="nav-item pcoded-hasmenu">
                                <a href="#!" class="nav-link "><span class="pcoded-mtext">Roles and
                                        Permission</span></a>
                                <ul class="pcoded-submenu">
                                    <li class="">
                                        <a href="{{ route('roles.index') }}">All Roles</a>
                                    </li>
                                    <li class="{{ Route::is('roles.create') ? 'active' : '' }}"><a
                                            href="{{ route('roles.create') }}">Add Role</a></li>
                                </ul>
                            </li>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="#!" class="nav-link "><span class="pcoded-mtext">Manage
                                            Profile</span></a>
                                <ul class="pcoded-submenu">
                                    <li><a href="{{ route('profileview') }}">Profile</a></li>
                                    <li class="{{ Route::is('password.view') ? 'active' : '' }}">
                                        <a href="{{ route('password.view') }}">Password Setting</a></li>
                                </ul>
                            </li>
                            <li class="nav-item pcoded-hasmenu">
                                <a href="#!" class="nav-link "><span class="pcoded-mtext">Manage
                                            Users</span></a>
                                <ul class="pcoded-submenu">
                                    <li>
                                        <a href="{{ route('users.index') }}">User List</a></li>
                                    <li class="{{ Route::is('users.create') ? 'active' : '' }}">
                                        <a href="{{ route('users.create') }}">Add User</a></li>
                                </ul>
                            </li>
                        <li class="nav-item"><a href="{{ route('audit.trail') }}">Audit Trail</a></li>
                        <li class="nav-item"><a href="{{ route('login_and_logout') }}">User Logs Activities</a></li>

                        </ul>
                    </li>
                @endcan

                <li class="nav-item pcoded">
                    <a href="{{ route('logout') }}" class="nav-link"><span class="pcoded-micon"><i
                                class="fas fa-sign-out-alt"></i></span><span
                                class="pcoded-mtext">Logout</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
