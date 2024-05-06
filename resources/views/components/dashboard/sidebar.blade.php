<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src={{ asset("dashboard/img/AdminLTELogo.png") }} alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Perpustakaan</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        {{-- <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> --}}
        <div class="info">
            @if(Auth::check())
            <a href="#" class="d-block">Hi, {{ Auth::user()->name }}</a>
            @endif
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item {{ request()->is('dashboard/overview') ? 'menu-open' : '' }}">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard/overview') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('dashboard/catalog') ? 'menu-open' : '' }}">
            <a href="{{ route('dashboard.catalog') }}" class="nav-link {{ request()->is('dashboard/catalog') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Catalog
              </p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('dashboard/publisher') ? 'menu-open' : '' }}">
            <a href="{{ route('dashboard.publisher') }}" class="nav-link {{ request()->is('dashboard/publisher') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Publisher
              </p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('dashboard/author') ? 'menu-open' : '' }}">
            <a href="{{ route('dashboard.author') }}" class="nav-link {{ request()->is('dashboard/author') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Author
              </p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('dashboard/book') ? 'menu-open' : '' }}">
            <a href="{{ route('dashboard.book') }}" class="nav-link {{ request()->is('dashboard/book') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Book
              </p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('dashboard/member') ? 'menu-open' : '' }}">
            <a href="{{ route('dashboard.member') }}" class="nav-link {{ request()->is('dashboard/member') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Member
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
