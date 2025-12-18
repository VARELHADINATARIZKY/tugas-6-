<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIKA</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Menu Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Menu Mahasiswa (hanya admin) -->
    <?php if($_SESSION['role'] == 'admin') : ?>
    <li class="nav-item">
        <a class="nav-link" href="mahasiswa.php">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Mahasiswa</span></a>
    </li>
    <?php endif; ?>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>

</ul>
