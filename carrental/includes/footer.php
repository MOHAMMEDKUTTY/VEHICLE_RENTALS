<?php 
if(isset($_POST['emailsubscibe']))
{
$subscriberemail=$_POST['subscriberemail'];
$sql ="SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
$query= $dbh -> prepare($sql);
$query-> bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<script>alert('Already Subscribed.');</script>";
}
else{
$sql="INSERT INTO  tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
$query = $dbh->prepare($sql);
$query->bindParam(':subscriberemail',$subscriberemail,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Subscribed successfully.');</script>";
}
else
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}
}
?>

<footer style="background-color: #007BFF; color: white;">
  <div class="footer-top" style="background-color: #007BFF; color: white;">
    <div class="container" style="color: white;">
      <div class="row" style="color: white;">

        <div class="col-md-6" style="color: white;">
          <h6 style="color: white;">About Us</h6>
          <ul style="color: white;">
            <li><a href="page.php?type=aboutus" style="color: white;">About Us</a></li>
            <!--<li><a href="page.php?type=faqs" style="color: white;">FAQs</a></li>
            <li><a href="page.php?type=privacy" style="color: white;">Privacy</a></li>
            <li><a href="page.php?type=terms" style="color: white;">Terms of use</a></li>-->
            <li><a href="admin/" style="color: white;">Admin Login</a></li>
          </ul>
        </div>

        <!--<div class="col-md-3 col-sm-6" style="color: white;">
          <h6 style="color: white;">Subscribe Newsletter</h6>
          <div class="newsletter-form" style="color: white;">
            <form method="post" style="color: white;">
              <div class="form-group" style="color: white;">
                <input type="email" name="subscriberemail" class="form-control newsletter-input" required placeholder="Enter Email Address" style="color: white;" />
              </div>
              <button type="submit" name="emailsubscibe" class="btn btn-block" style="color: white;">Subscribe <span class="angle_arrow" style="color: white;"><i class="fa fa-angle-right" aria-hidden="true" style="color: white;"></i></span></button>
            </form>
            <p class="subscribed-text" style="color: white;">*We send great deals and latest auto news to our subscribed users very week.</p>
          </div>
        </div>-->
      </div>
    </div>
  </div>
  <div class="footer-bottom" style="background-color: #007BFF; color: white;">
    <div class="container" style="color: white;">
      <div class="row" style="color: white;">
        <div class="col-md-6 col-md-pull-6" style="color: white;">
          <p class="copy-right" style="color: white;"> VEHICLEBOOKING.COM by GROUP 14</p>
        </div>
      </div>
    </div>
  </div>
</footer>
