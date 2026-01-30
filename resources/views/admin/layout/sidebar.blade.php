<li class="nav-item-header pt-0">
    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Main</div>
    <i class="ph-dots-three sidebar-resize-show"></i>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
        <i class="ph-house"></i>
        <span>Dashboard</span>
    </a>
</li>
@can('media-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('media') ? 'active' : '' }}" href="{{ route('media.index') }}">
            <i class="ph-files"></i>
            <span>Media</span>
        </a>
    </li>
@endcan
{{-- @can('participants-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('participants.*') ? 'active' : '' }}"
            href="{{ route('participants.index') }}">
            <i class="ph-folder-user"></i>
            <span>Participants</span>
        </a>
    </li>
@endcan
@can('coupons-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('coupons.*') ? 'active' : '' }}" href="{{ route('coupons.index') }}">
            <i class="ph-gift"></i>
            <span>Coupons</span>
        </a>
    </li>
@endcan
@can('prizes-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('prizes.*') ? 'active' : '' }}" href="{{ route('prizes.index') }}">
            <i class="ph-money"></i>
            <span>Prizes</span>
        </a>
    </li>
@endcan
@can('winners-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('winners.*') ? 'active' : '' }}" href="{{ route('winners.index') }}">
            <i class="ph-trophy"></i>
            <span>Winners</span>
        </a>
    </li>
@endcan --}}
@canany(['countries-list', 'states-list', 'cities-list','currencies-list','accounts-list','persons-list','transaction-categories-list','transactions-list'])
    <li class="nav-item-header">
        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Catalog Management</div>
        <i class="ph-dots-three sidebar-resize-show"></i>
    </li>
@endcanany
@can('countries-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('countries*') ? 'active' : ''}}" href="{{ route('countries.index') }}">
            <i class="ph-map-pin"></i>
            <span>Countries</span>
        </a>
    </li>
@endcan
{{-- @can('provinces-list')
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('provinces*') ? 'active' : ''}}" href="{{ route('provinces.index') }}">
        <i class="ph-map-pin"></i>
        <span>Provinces</span>
    </a>
</li>
@endcan --}}
@can('states-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('states*') ? 'active' : '' }}" href="{{ route('states.index') }}">
            <i class="ph-map-pin"></i>
            <span>States</span>
        </a>
    </li>
@endcan
@can('cities-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('cities*') ? 'active' : '' }}" href="{{ route('cities.index') }}">
            <i class="ph-map-pin"></i>
            <span>Cities</span>
        </a>
    </li>
@endcan
@can('currencies-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('currencies*') ? 'active' : '' }}" href="{{ route('currencies.index') }}">
            <i class="ph-map-pin"></i>
            <span>Currencies</span>
        </a>
    </li>
@endcan
@can('accounts-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('accounts*') ? 'active' : '' }}" href="{{ route('accounts.index') }}">
            <i class="ph-map-pin"></i>
            <span>Accounts</span>
        </a>
    </li>
@endcan
@can('persons-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('persons*') ? 'active' : '' }}" href="{{ route('persons.index') }}">
            <i class="ph-map-pin"></i>
            <span>Persons</span>
        </a>
    </li>
@endcan
@can('transaction-categories-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('transaction-categories*') ? 'active' : '' }}" href="{{ route('transaction-categories.index') }}">
            <i class="ph-map-pin"></i>
            <span>Transaction Categories</span>
        </a>
    </li>
@endcan
@can('transactions-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('transactions*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
            <i class="ph-map-pin"></i>
            <span>Transactions</span>
        </a>
    </li>
@endcan
@canany(['accounts-ledger-report'])
    <li class="nav-item-header">
        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Reports</div>
        <i class="ph-dots-three sidebar-resize-show"></i>
    </li>
@endcanany
@can('accounts-ledger-report')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('reports.accounts-ledger*') ? 'active' : '' }}" href="{{ route('reports.accounts-ledger') }}">
            <i class="ph-map-pin"></i>
            <span>Accounts Ledger</span>
        </a>
    </li>
@endcan
@canany(['roles-list', 'permissions-list', 'users-list'])
    <li class="nav-item-header">
        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Access Management</div>
        <i class="ph-dots-three sidebar-resize-show"></i>
    </li>
@endcanany
@can('roles-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('roles*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
            <i class="ph-atom"></i>
            <span>Roles</span>
        </a>
    </li>
@endcan
@can('permissions-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('permissions*') ? 'active' : '' }}"
           href="{{ route('permissions.index') }}">
            <i class="ph-atom"></i>
            <span>Permissions</span>
        </a>
    </li>
@endcan
@can('users-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users*') ? 'active' : '' }}" href="{{ route('users.index') }}">
            <i class="ph-users"></i>
            <span>Users</span>
        </a>
    </li>
@endcan
@canany(['notifications-list', 'audits-list', 'logs-list'])
    <li class="nav-item-header">
        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Configuration</div>
        <i class="ph-dots-three sidebar-resize-show"></i>
    </li>
@endcanany
@can('audits-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('notifications*') ? 'active' : '' }}"
           href="{{ route('notifications.index') }}">
            <i class="ph-bell"></i>
            <span>Notifications</span>
        </a>
    </li>
@endcan
@can('audits-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('audits*') ? 'active' : '' }}" href="{{ route('audits.index') }}">
            <i class="ph-diamonds-four"></i>
            <span>Audit</span>
        </a>
    </li>
@endcan
@can('logs-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('logs*') ? 'active' : '' }}" href="{{ route('logs') }}"
           target="_blank">
            <i class="ph-bug"></i>
            <span>Errors</span>
        </a>
    </li>
@endcan
@can('settings-list')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('settings*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
            <i class="ph-gear"></i>
            <span>Settings</span>
        </a>
    </li>
@endcan
