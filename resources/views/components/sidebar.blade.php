<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            @role('admin')
                <a href="{{ route('home.admin') }}">ADMIN BY HIM</a>
                @endrole

                @role('staff')
                <a href="{{ route('home') }}">ADMIN BY HIM</a>
                @endrole
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">AB</a>
        </div>
        <ul class="sidebar-menu">

            <li>
                @role('admin')
                <a href="{{ route('home.admin') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                @endrole

                @role('staff')
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                @endrole
            </li>

            <li class="menu-header">Header</li>

            @role('admin')
            <li class='{{ Request::routeIs('branches.index') ? 'active' : '' }}'>
                <a href="{{ route('branches.index') }}" class="nav-link">Branch</a>
            </li>
            @endrole

            @role('admin')
            <li class='{{ Request::routeIs('users.index') ? 'active' : '' }}'>
                <a href="{{ route('users.index') }}" class="nav-link">Users</a>
            </li>
            @endrole

            @role('admin')
            <li class='{{ Request::routeIs('categories.index') ? 'active' : '' }}'>
                <a href="{{ route('categories.index') }}" class="nav-link">Category</a>
            </li>
            @endrole

            @hasanyrole('admin|staff')
            <li class='{{ Request::routeIs('products.index') ? 'active' : '' }}'>
                <a href="{{ route('products.index') }}" class="nav-link">Products</a>
            </li>
            @endhasanyrole

            @role('admin')
            <li class='{{ Request::routeIs('bottle.index') ? 'active' : '' }}'>
                <a href="{{ route('bottle.index') }}" class="nav-link">Bottle</a>
            </li>
            @endrole

            @hasanyrole('admin|staff')
            <li class='{{ Request::is('report*') ? 'active' : '' }}'>
                <a href="{{ URL::to('report') }}" class="nav-link">Report</a>
            </li>
            @endhasanyrole

            @hasanyrole('admin|staff')
            <li class='{{ Request::routeIs('stock.index') ? 'active' : '' }}'>
                <a href="{{ route('stock.index') }}" class="nav-link">Stock</a>
            </li>
            @endhasanyrole

            @hasanyrole('admin|staff')
            <li class='{{ Request::routeIs('stockcard.index') ? 'active' : '' }}'>
                <a href="{{ route('stockcard.index') }}" class="nav-link">Stock Card</a>
            </li>
            @endhasanyrole

            @hasanyrole('admin|staff')
            <li class='{{ Request::routeIs('bundles.index') ? 'active' : '' }}'>
                <a href="{{ route('bundles.index') }}" class="nav-link">Bundles</a>
            </li>
            @endhasanyrole

            @hasanyrole('admin|staff')
            <li class='{{ Request::routeIs('customers.index') ? 'active' : '' }}'>
                <a href="{{ route('customers.index') }}" class="nav-link">Customers</a>
            </li>
            @endhasanyrole

            {{-- Additional menu items with appropriate authorization checks --}}
        </ul>
    </aside>
</div>
