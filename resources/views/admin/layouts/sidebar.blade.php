<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/')}}" class="brand-link">
        <img src="{{asset('../assets/admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light" style="text-transform: uppercase"> {{ Auth::user()->name }} </span>
    </a>      
      <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.rooms.view')}}" class="nav-link">
                        <i class="nav-icon fas fa-bed"></i>
                        <p>Rooms</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.bookings.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-calendar-alt"></i>
                        <p>Bookings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.offers.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Offers</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p> Users</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{route('admin.loyality.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p> Loyality</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-star"></i>
                        <p>Reviews</p>
                    </a>
                </li> --}}
   
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
</aside>