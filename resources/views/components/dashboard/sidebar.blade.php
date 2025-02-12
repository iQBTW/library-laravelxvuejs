<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src={{ asset('dashboard/img/AdminLTELogo.png') }} alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">E-Library</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel d-flex mb-3 mt-3 pb-3">
            {{-- <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> --}}
            <div class="info">
                @if (Auth::check())
                    <a href="#" class="d-block">Hi, {{ Auth::user()->name }}</a>
                @endif
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item {{ request()->is('dashboard/overview') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard/overview') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('transactions') ? 'menu-open' : '' }}">
                    <a href="{{ url('transactions') }}"
                        class="nav-link {{ request()->is('transactions') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calendar-plus"></i>
                        <p>
                            Peminjaman
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('books') ? 'menu-open' : '' }}">
                    <a href="{{ url('books') }}" class="nav-link {{ request()->is('books') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Book
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('catalogs') ? 'menu-open' : '' }}">
                    <a href="{{ url('catalogs') }}" class="nav-link {{ request()->is('catalogs') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-paperclip"></i>
                        <p>
                            Catalog
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('publishers') ? 'menu-open' : '' }}">
                    <a href="{{ url('publishers') }}"
                        class="nav-link {{ request()->is('publishers') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-badge"></i>
                        <p>
                            Publisher
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('authors') ? 'menu-open' : '' }}">
                    <a href="{{ url('authors') }}" class="nav-link {{ request()->is('authors') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Author
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('members') ? 'menu-open' : '' }}">
                    <a href="{{ url('members') }}" class="nav-link {{ request()->is('members') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Member
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('users') ? 'menu-open' : '' }}">
                    <a href="{{ url('users') }}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
