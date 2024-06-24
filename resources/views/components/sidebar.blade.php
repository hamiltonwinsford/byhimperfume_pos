<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ URL::to('home') }}">ADMIN BY HIM</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">AB</a>
        </div>
        <ul class="sidebar-menu">

            <li>
                <a href="{{ URL::to('home') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <li class="menu-header">Header</li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('branches.index') }}" class="nav-link">Branch</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('users.index') }}" class="nav-link">Users</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('categories.index') }}" class="nav-link">Category</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('products.index') }}" class="nav-link">Products</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('bottle.index') }}" class="nav-link">Bottle</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ URL::to('report') }}" class="nav-link">Report</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('stock.index') }}" class="nav-link">Stock</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('stockcard.index') }}" class="nav-link">Stock Card</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('bundles.index') }}" class="nav-link">Customers</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('customers.index') }}" class="nav-link">Customers</a>
            </li>
            {{-- <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('promotions.index') }}" class="nav-link">Promotions</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('promotionBundle.index') }}" class="nav-link">Promotions Bundle</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('first_stock.index') }}" class="nav-link">First stock</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('opname.index') }}" class="nav-link">Opname</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('other_product.index') }}" class="nav-link">Other Products</a>
            </li>
            <li class='{{ Request::is('dashboard-general-dashboard') ? 'active' : '' }}'>
                <a href="{{ route('supplier.index') }}" class="nav-link">Supplier</a>
            </li>--}}
        </ul>
    </aside>

</div>
