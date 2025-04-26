<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
</style>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('images/buk.png') }}" alt="" srcset="" width="30" height="30">
        </div>
        <div class="sidebar-brand-text mx-3">Depression<sup></sup></div>
    </a>
    

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">


    <!-- Nav Item - Patients -->
    <li class="nav-item {{ request()->routeIs('admin.tests*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.tests') }}">
            <i class="fas fa-fw fa-hourglass-half"></i>
            <span>Tests</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

     <!-- Nav Item - Patients -->
     <li class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Video Feed -->
    <li class="nav-item {{ request()->routeIs('admin.video-feed') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.video-feed') }}">
            <i class="fas fa-fw fa-video"></i>
            <span>Video Feed</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

