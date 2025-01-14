<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Dashboard Menu -->
    <li class="nav-item">
      <a href="index.php?page=dashboard" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'dashboard') ? 'active' : ''; ?>">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>

    <!-- SPK Menu -->
    <li class="nav-item menu-open">
      <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-calculator"></i>
        <p>
          SPK Penentuan Supplier
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="index.php?page=alternatif" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'alternatif') ? 'active' : ''; ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Alternatif</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?page=kriteria" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'kriteria') ? 'active' : ''; ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Kriteria</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?page=penilaian" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'penilaian') ? 'active' : ''; ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Penilaian</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?page=hasil" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'hasil') ? 'active' : ''; ?>">
            <i class="far fa-circle nav-icon"></i>
            <p>Hasil SPK</p>
          </a>
        </li>
      </ul>
    </li>

    <!-- Logout Menu -->
    <li class="nav-item">
      <a href="logout.php" class="nav-link text-red">
        <i class="nav-icon fas fa-power-off"></i>
        <p>Logout</p>
      </a>
    </li>
  </ul>
</nav>
