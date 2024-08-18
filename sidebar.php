<?php include 'session.php';?>
<script src="https://cdn.tailwindcss.com"></script>
<script src="http://localhost/js/tailwind.config.js"></script>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <i class="fab fa-buromobelexperte"></i>
        <div class="sidebar-brand-text mx-3">DASHBOARD</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="event-add.php">
        <i class="fas fa-calendar-plus"></i>

            <span>Add Event</span>
        </a>
    </li>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="event.php">
            <i class="fas fa-calendar-alt"></i>
            <span>Event</span>
        </a>
    </li>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->