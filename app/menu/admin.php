<nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Bengkel
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
              <a href="index.php?page=sparepart" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'sparepart') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
                  <p>Sparepart</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="index.php?page=supplier" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'supplier') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
                  <p>Supplier</p>
                </a>
              </li>
              </li>
              <li class="nav-item">
              <a href="index.php?page=pelanggan" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'pelanggan') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pelanggan</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="index.php?page=transaksi" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'transaksi') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaksi</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
          <a href="index.php?page=dashboard" class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'dashboard') ? 'active' : ''; ?>">
          <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link text-red">
              <i class="nav-icon fas  fa-power-off"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          
        </ul>
      </nav>