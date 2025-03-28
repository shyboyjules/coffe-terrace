  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link " href="user-management.php">
          <i class="bi bi-people"></i>
          <span>Users</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#inventory-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-box-seam"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="inventory-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="view-inventory.php">
              <i class="bi bi-circle"></i><span>View Inventory</span>
            </a>
          </li>
          <li>
            <a href="inventory-add.php">
              <i class="bi bi-circle"></i><span>Add Item</span>
            </a>
          </li>
          <li>
            <a href="stock-management.php">
              <i class="bi bi-circle"></i><span>Stock Management</span>
            </a>
          </li>
       
        </ul>
      </li><!-- End Inventory Nav -->
      
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
