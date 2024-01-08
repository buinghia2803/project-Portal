<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.home') }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        {{-- @can('divisions_access') --}}
        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.divisions.index') }}"
                class="c-sidebar-nav-link {{ request()->is('admin/divisions') || request()->is('admin/divisions/*') ? 'active' : '' }}">
                <i class="fas fa-smile c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.divisions.title') }}
            </a>
        </li>
        {{-- @endcan
        @can('notification_access') --}}
        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.notification.index') }}"
                class="c-sidebar-nav-link {{ request()->is('admin/notification') || request()->is('admin/notification/*') ? 'active' : '' }}">
                <i class="fas fa-check c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.notification.title') }}
            </a>
        </li>
        {{-- @endcan
        @can('requests_access') --}}
        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.requests.index') }}"
                class="c-sidebar-nav-link {{ request()->is('admin/requests') || request()->is('admin/requests/*') ? 'active' : '' }}">
                <i class="fas fa-kiss-wink-heart c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.requests.title') }}
            </a>
        </li>
        {{-- @endcan --}}
        {{-- @can('leave_access') --}}
        {{-- <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.leaves.index') }}"
                class="c-sidebar-nav-link {{ request()->is('admin/leaves') || request()->is('admin/leaves/*') ? 'active' : '' }}">
                <i class="fas fa-leaf c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.leave.title') }}
            </a>
        </li> --}}
        {{-- @endcan --}}
        @can('user_management_access')
        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                </i>
                {{ trans('cruds.memberManagement.title') }}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                @can('permission_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route('admin.permissions.index') }}"
                        class="c-sidebar-nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.permission.title') }}
                    </a>
                </li>
                @endcan
                @can('role_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route('admin.roles.index') }}"
                        class="c-sidebar-nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.role.title') }}
                    </a>
                </li>
                @endcan
                @can('user_access')
                <li class="c-sidebar-nav-item">
                    <a href="{{ route('admin.members.index') }}"
                        class="c-sidebar-nav-link {{ request()->is('admin/members') || request()->is('admin/members/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.members.title') }}
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            {{-- @can('profile_password_edit') --}}
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}"
                    href="{{ route('profile.password.edit') }}">
                    <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                    </i>
                    {{ trans('global.change_password') }}
                </a>
            </li>
            {{-- @endcan --}}
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link"
                onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
