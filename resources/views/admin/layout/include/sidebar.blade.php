@php($url = url()->full())
@php($user = Auth::user())
<ul id="sidebarnav">
    <li class="user-pro">
        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
            <img src="{{ secure_file_url(auth()->user()->profile_picture) }}" alt="user-img" class="img-circle">
            <span class="hide-menu">{{ Auth::user()->name }}</span>
        </a>
        <ul aria-expanded="false" class="collapse">
            <li><a href="{{ route('user.profile.edit') }}"><i class="ti-user"></i> My Profile</a></li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i> Logout
                </a>
            </li>
        </ul>
    </li>
    <li>
        <a class="waves-effect waves-dark" href="{{ route('dashboard') }}" aria-expanded="false">
            <i class="icon-speedometer"></i><span class="hide-menu">Dashboard</span>
        </a>
    </li>
    @can('roles-list')
    <li>
        <a class="waves-effect waves-dark" href="{{ route('roles.index') }}" aria-expanded="false">
            <i class="icons-Control"></i><span class="hide-menu">Roles</span>
        </a>
    </li>
    @endcan
    @can('users-list')
    <li>
        <a class="waves-effect waves-dark" href="{{ route('users.index') }}" aria-expanded="false">
            <i class="icons-Administrator"></i><span class="hide-menu">Users</span>
        </a>
    </li>
    @endcan
{{--    @can('language-list')--}}
{{--    <li>--}}
{{--        <a class="waves-effect waves-dark" href="{{ route('languages.index') }}" aria-expanded="false">--}}
{{--            <i class="icons-Map"></i><span class="hide-menu">Languages</span>--}}
{{--        </a>--}}
{{--    </li>--}}
{{--    @endcan--}}
{{--    @can('media-list')--}}
    <li>
        <a class="waves-effect waves-dark" href="{{ route('media.index') }}" aria-expanded="false">
            <i class="icons-Camera-2"></i><span class="hide-menu">Media</span>
        </a>
    </li>
{{--    @endcan--}}
    @can('apiToken-list')
    <li>
        <a class="waves-effect waves-dark" href="{{ route('api-tokens.index') }}" aria-expanded="false">
            <i class="icons-Code-Window"></i><span class="hide-menu">API Tokens</span>
        </a>
    </li>
    @endcan
    <li>
        <a class="waves-effect waves-dark" href="{{ route('notifications.index') }}" aria-expanded="false">
            <i class="fas fa-bell"></i><span class="hide-menu">Notification</span>
        </a>
    </li>
    @can('settings-list')
    <li>
        <a class="waves-effect waves-dark" href="{{ route('settings.index') }}" aria-expanded="false">
            <i class="ti-settings"></i><span class="hide-menu">Settings</span>
        </a>
    </li>
    <li>
        <a class="waves-effect waves-dark" href="{{ route('settings.clear-cache') }}" aria-expanded="false">
            <i class="icons-Refresh"></i><span class="hide-menu">Clear Cache</span>
        </a>
    </li>
    @endcan
    @can('audit-list')
    <li>
        <a class="waves-effect waves-dark" href="{{ route('audit.index') }}" aria-expanded="false">
            <i class="icons-Time-Backup"></i><span class="hide-menu">Audits</span>
        </a>
    </li>
    @endcan
    @can('log-list') 
    <li>
        <a class="waves-effect waves-dark" href="{{ route('logs') }}" aria-expanded="false" target="_blank">
            <i class="icons-Calendar-4"></i><span class="hide-menu">Logs</span>
        </a>
    </li>
    @endcan
    <li>
        <a class="waves-effect waves-dark" href="{{ route('logout') }}" aria-expanded="false" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="far fa-circle text-success"></i><span class="hide-menu">Log Out</span>
        </a>
    </li>
</ul>
        