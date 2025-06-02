<header>
  <div class="default-header" style="background-color: #007BFF; color: white;">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2">
          <div class="logo">
            <a href="index.php">
              <span style="color: white; font-size: 24px; font-weight: bold;">VehicleBooking.com</span>
            </a>
          </div>
        </div>
        <div class="col-sm-9 col-md-10">
          <div class="header_info">
            <?php if(strlen($_SESSION['login'])==0) { ?>
              <div class="login_btn">
                <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal" style="background-color: white; color: #007BFF;">Login / Register</a>
              </div>
            <?php } else { ?>
              <span style="color: white;">Welcome To VehicleBooking.com Project</span>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation -->
  <nav id="navigation_bar" class="navbar navbar-default" style="background-color: #0056b3; border-color: #004085;">
    <div class="container">
      <div class="navbar-header">
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button" style="background-color: white;">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar" style="background-color: #007BFF;"></span>
          <span class="icon-bar" style="background-color: #007BFF;"></span>
          <span class="icon-bar" style="background-color: #007BFF;"></span>
        </button>
      </div>
      <div class="header_wrap">
        <div class="user_login">
          <ul>
            <li class="dropdown">
              <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                <i class="fa fa-user-circle" aria-hidden="true"></i>
                <?php
                $email=$_SESSION['login'];
                $sql ="SELECT FullName FROM tblusers WHERE EmailId=:email ";
                $query= $dbh -> prepare($sql);
                $query-> bindParam(':email', $email, PDO::PARAM_STR);
                $query-> execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                if($query->rowCount() > 0) {
                  foreach($results as $result) {
                    echo htmlentities($result->FullName);
                  }
                }
                ?>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </a>
              <ul class="dropdown-menu">
                <?php if($_SESSION['login']) { ?>
                  <li><a href="profile.php">Profile Settings</a></li>
                  <li><a href="update-password.php">Update Password</a></li>
                  <li><a href="my-booking.php">My Booking</a></li>
                  <li><a href="logout.php">Sign Out</a></li>
                <?php } else { ?>
                  <li><a href="#loginform" data-toggle="modal" data-dismiss="modal">Profile Settings</a></li>
                  <li><a href="#loginform" data-toggle="modal" data-dismiss="modal">Update Password</a></li>
                  <li><a href="#loginform" data-toggle="modal" data-dismiss="modal">My Booking</a></li>
                  <li><a href="#loginform" data-toggle="modal" data-dismiss="modal">Sign Out</a></li>
                <?php } ?>
              </ul>
            </li>
          </ul>
        </div>
        <div class="header_search">
          <div id="search_toggle"><i class="fa fa-search" aria-hidden="true" style="color: white;"></i></div>
          <form action="#" method="get" id="header-search-form">
            <input type="text" placeholder="Search..." class="form-control" style="border-color: #007BFF;">
            <button type="submit" style="background-color: #007BFF; color: white;"><i class="fa fa-search" aria-hidden="true"></i></button>
          </form>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
          <li><a href="index.php" style="color: white;">Home</a></li>
          <li><a href="page.php?type=aboutus" style="color: white;">About Us</a></li>
          
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navigation end -->
</header>
