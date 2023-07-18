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
                    <h6 class="submenu-hdr">Bill Management</h6>
                    <ul>
                        <li class="{{ Route::is('purchase.index', 'purchase.store') ? 'active' : '' }}">
                            <a href="{{ route('purchase.branchdata', ['branch_id' => '1']) }}"><i data-feather="shopping-bag"></i><span>Purchase</span></a>
                        </li>
                        <li class="{{ Route::is('sales.index', 'sales.store') ? 'active' : '' }}">
                            <a href="{{ route('sales.branchdata', ['branch_id' => '1']) }}"><i data-feather="shopping-cart"></i><span>Sales</span></a>
                        </li>
                        <li class="{{ Route::is('expence.index', 'expence.store') ? 'active' : '' }}">
                            <a href="{{ route('expence.index') }}"><i data-feather="corner-up-left"></i><span>Expence</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Order</h6>
                    <ul>
                        <li class="{{ Route::is('purchaseorder.purchaseorder_index') ? 'active' : '' }}">
                            <a href="{{ route('purchaseorder.purchaseorder_branchdata', ['branch_id' => '1']) }}"><i data-feather="shopping-bag"></i><span>Purchase Order</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Payment</h6>
                    <ul>
                        <li class="{{ Route::is('purchasepayment.index', 'purchasepayment.store') ? 'active' : '' }}">
                            <a href="{{ route('purchasepayment.index') }}"><i data-feather="columns"></i></i><span>Purchase Receipt</span></a>
                        </li>
                        <li class="{{ Route::is('salespayment.index', 'salespayment.store') ? 'active' : '' }}">
                            <a href="{{ route('salespayment.index') }}"><i data-feather="pen-tool"></i><span>Sales Receipt</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Report</h6>
                    <ul>
                        <li class="{{ Route::is('purchase.report') ? 'active' : '' }}">
                            <a href="{{ route('purchase.report') }}"><i data-feather="pie-chart"></i><span>Purchase Report</span></a>
                        </li>
                        <li class="{{ Route::is('sales.report') ? 'active' : '' }}">
                            <a href="{{ route('sales.report') }}"><i data-feather="bar-chart-2"></i><span>Sales Report</span></a>
                        </li>
                        <li class="{{ Route::is('expence.report') ? 'active' : '' }}">
                            <a href="{{ route('expence.report') }}"><i data-feather="credit-card"></i><span>Expense Report</span></a>
                        </li>
                        <li class="{{ Route::is('stockmanagement.index') ? 'active' : '' }}">
                            <a href="{{ route('stockmanagement.index') }}"><i data-feather="database"></i><span>Stock</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">General</h6>
                    <ul>
                        <li class="{{ Route::is('branch.index', 'branch.store', 'branch.edit') ? 'active' : '' }}">
                            <a href="{{ route('branch.index') }}"><i data-feather="map"></i><span>Branch</span></a>
                        </li>
                        <li class="{{ Route::is('unit.index', 'unit.store', 'unit.edit') ? 'active' : '' }}" hidden>
                            <a href="{{ route('unit.index') }}"><i data-feather="map"></i><span>Unit</span></a>
                        </li>
                        <li class="{{ Route::is('bank.index', 'bank.store', 'bank.edit') ? 'active' : '' }}">
                            <a href="{{ route('bank.index') }}"><i data-feather="credit-card"></i><span>Bank</span></a>
                        </li>

                        <li class="{{ Route::is('product.index', 'product.store', 'product.edit') ? 'active' : '' }}">
                            <a href="{{ route('product.index') }}"><i data-feather="box"></i><span>Product</span></a>
                        </li>
                    </ul>
                </li>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">User Management</h6>
                    <ul>
                        <li class="{{ Route::is('supplier.index') ? 'active' : '' }}">
                            <a href="{{ route('supplier.index') }}"><i data-feather="users"></i><span>Supliers</span></a>
                        </li>
                        <li class="{{ Route::is('customer.index', 'customer.store') ? 'active' : '' }}">
                            <a href="{{ route('customer.index') }}"><i data-feather="user"></i><span>Customers</span></a>
                        </li>
                        @hasrole('Super-Admin')
                        <li class="{{ Route::is('invite.index', 'invite.store') ? 'active' : '' }}">
                            <a href="{{ route('invite.index') }}"><i data-feather="user-check"></i><span>Managers</span></a>
                        </li>
                        @endhasrole
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
