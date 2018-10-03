<?php
    include_once('Backend/_authcheck.php');
    if(authCheck()){
?>
  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

  <a class="navbar-brand mr-1" href="home.php" title="Home">
      <img class="img-rounded logo" src="Contents/Images/logo3.png" height="40px" width="100px">
  </a>

<?php
        if(getRoleID() == 2){
?>
            <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
                <i class="fas fa-bars"></i>
            </button>
<?php
        }

?>

<!-- Navbar Search -->
<form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
  <div class="input-group">
    <!-- <input type="text" class="form-control form-control-sm btn-outline-secondary" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
    <div class="input-group-append">
      <button class="btn btn-sm btn-outline-secondary" type="button" title="Search">
        <i class="fas fa-search"></i>
      </button>
    </div> -->
  </div>
</form>

<!-- Navbar -->
<ul class="navbar-nav ml-auto ml-md-0">
  <li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle btn-sm" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Services">
      <i class="fas fa-th fa-fw"></i> Services
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
      <a class="dropdown-item" href="emergency.php"><i class="fas fa-ambulance fa-fw"></i> Medical Emergency</a>
      <a class="dropdown-item" href="smileybot.php"><i class="fas fa-stethoscope fa-fw"></i> Smiley Bot</a>
      <a class="dropdown-item" href="finddoctor.php"><i class="fas fa-user-md fa-fw"></i> Find Doctor</a>
      <a class="dropdown-item" href="firstaidkit.php"> <i class="fas fa-first-aid fa-fw"></i> First Aid Kit</a>
      
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="lifeline.php"><i class="fas fa-history fa-fw"></i> Lifeline</a>
    </div>
  </li>

  <li class="nav-item dropdown no-arrow">
    <a class="nav-link dropdown-toggle btn-sm" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="User actions">
      <i class="fas fa-user-circle fa-fw"></i> <?php echo  getUserName();?>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
      <a class="dropdown-item" href="#">Settings</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Sign out</a>
    </div>
  </li>
</ul>

</nav>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Sign out" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" onclick="signOut();">Sign out</button>
        </div>
      </div>
    </div>
  </div>


    <!-- Sign out Script -->
    <script>
        function signOut(){
          delete_cookie('auth', '/', window.location.hostname);
          deleteAllCookies();
          window.location = "signout.php";
            // let rdr = delete_cookie('auth', '/', window.location.hostname);  
            // if(rdr){
            //     window.location = "./";
            // }
        }
        function deleteAllCookies() {
            var cookies = document.cookie.split(";");

            for (var i = 0; i < cookies.length; i++) {
                var cookie = cookies[i];
                var eqPos = cookie.indexOf("=");
                var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
                document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=[/];"
            }
        }

        function delete_cookie( name, path, domain ) {
            
            document.cookie = name + "=" +
                ((path) ? ";path="+path:"")+
                ((domain)?";domain="+domain:"") +
                ";expires=Thu, 01 Jan 1970 00:00:01 GMT";
            return true;
        }
    </script>


<?php
}

?>
