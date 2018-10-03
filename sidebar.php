<?php
    include_once('Backend/_authcheck.php');
    if(authCheck() && getRoleID() == 2){
?>
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav toggled">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>

         <li class="nav-item">
          <a class="nav-link" href="dataentry.php">
            <i class="fas fa-fw fa-list"></i>
            <span>Data Entry</span></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="handleuser.php">
            <i class="fas fa-fw fa-user"></i>
            <span>User Handle</span></a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="charts.php">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tables.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
        </li>
      </ul>
<?php
    }
?>

