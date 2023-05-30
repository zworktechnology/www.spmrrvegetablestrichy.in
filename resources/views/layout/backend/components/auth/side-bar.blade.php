<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Main</h6>
                    <ul>
                        <li class="{{ Route::is('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}"><i data-feather="grid"></i><span>Dashboard</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">User Management</h6>
                    <ul>
                        <li class="{{ Route::is('customer.index', 'customer.store') ? 'active' : '' }}">
                            <a href="{{ route('customer.index') }}"><i data-feather="user"></i><span>Customers</span></a>
                        </li>
                        <li class="{{ Route::is('supplier.index') ? 'active' : '' }}">
                            <a href="{{ route('supplier.index') }}"><i data-feather="users"></i><span>Supliers</span></a>
                        </li>
                        @hasrole('Super-Admin')
                        <li class="{{ Route::is('invite.index', 'invite.store') ? 'active' : '' }}">
                            <a href="{{ route('invite.index') }}"><i data-feather="user-check"></i><span>Managers</span></a>
                        </li>
                        @endhasrole
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Settings</h6>
                    <ul>
                        <li class="{{ Route::is('branch.index', 'branch.store', 'branch.edit') ? 'active' : '' }}">
                            <a href="{{ route('branch.index') }}"><i data-feather="map"></i><span>Branch</span></a>
                        </li>
                        <li class="{{ Route::is('unit.index', 'unit.store', 'unit.edit') ? 'active' : '' }}">
                            <a href="{{ route('unit.index') }}"><i data-feather="map"></i><span>Unit</span></a>
                        </li>
                        <li class="{{ Route::is('bank.index', 'bank.store', 'bank.edit') ? 'active' : '' }}">
                            <a href="{{ route('bank.index') }}"><i data-feather="map"></i><span>Bank</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
