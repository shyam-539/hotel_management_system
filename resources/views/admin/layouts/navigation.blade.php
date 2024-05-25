
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
    </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
        @if(Auth::check())
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }} <i class="fas fa-caret-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <!-- Authentication -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                </form>
            </div>
        @else
            <a class="nav-link" href="{{ url('/dashboard') }}">Login</a>
        @endif
    </li>
     <!-- Messages Dropdown Menu -->
 
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">{{$notificationCount}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{$notificationCount}} Notifications</span>
            <div class="dropdown-divider"></div>
            <!-- Loop through notifications and display them -->
            <div class="notification-container">
                @foreach($notifications as $notification)
                <a href="{{ route('admin.notification.edit', ['id' => $notification->id]) }}" class="dropdown-item notification-box" data-notification-id="{{ $notification->id }}" data-booking-id="{{ $notification->booking_id }}">
                    <p>{{ $notification->message }}</p>
                    <p>
                      {{ $notification->created_at }} 
                        <span style="color: {{ $notification->status == 1 ? 'red' : 'green' }}"> 
                        - {{ $notification->status == 1 ? 'Unseen' : 'Seen' }} </span >
                    </p>
                </a>
                <div class="dropdown-divider"></div>
                @endforeach
            </div>
            
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>
   
    </ul>
</nav>
