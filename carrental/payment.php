<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if user is logged in
if(strlen($_SESSION['login'])==0) {
    header('location:index.php');
    exit();
}

// Get booking ID from URL
$bookingId = isset($_GET['bid']) ? intval($_GET['bid']) : 0;

// Verify booking belongs to logged in user
$useremail = $_SESSION['login'];
$sql = "SELECT * FROM tblbooking WHERE id=:bid AND userEmail=:useremail";
$query = $dbh->prepare($sql);
$query->bindParam(':bid', $bookingId, PDO::PARAM_INT);
$query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$booking = $query->fetch(PDO::FETCH_OBJ);

if(!$booking || $booking->Status != 1) {
    header('location:my-booking.php');
    exit();
}

// Get vehicle details and calculate total
$sql = "SELECT v.VehiclesTitle, b.BrandName, v.PricePerDay,
        4 as days,
        (v.PricePerDay * 4) as total
        FROM tblvehicles v 
        JOIN tblbrands b ON b.id = v.VehiclesBrand 
        JOIN tblbooking ON tblbooking.VehicleId = v.id
        WHERE v.id=:vid AND tblbooking.id=:bid";
$query = $dbh->prepare($sql);
$query->bindParam(':vid', $booking->VehicleId, PDO::PARAM_INT);
$query->bindParam(':bid', $bookingId, PDO::PARAM_INT);
$query->execute();
$vehicle = $query->fetch(PDO::FETCH_OBJ);

// Process payment if form submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // In a real system, you would process payment here
    // For demo, we'll just redirect to success page
    
    header("location:payment-success.php?bid=$bookingId");
    exit();
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>CarForYou - Payment</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/payment.css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<?php include('includes/header.php');?>

<div class="container payment-container">
    <h2>Complete Your Payment</h2>
    <div class="booking-summary">
        <h4>Booking #<?php echo $booking->id; ?></h4>
        <p>Vehicle: <?php echo htmlentities($vehicle->BrandName.' '.$vehicle->VehiclesTitle); ?></p>
        <p>Dates: <?php echo htmlentities($booking->FromDate.' to '.$booking->ToDate); ?></p>
            <p>Price per day: ₹<?php echo htmlentities($vehicle->PricePerDay); ?></p>
            <p>Total days: 4</p>
            <h5>Total Amount: ₹<?php echo htmlentities($vehicle->total); ?></h5>
    </div>

    <form id="payment-form" method="post">
        <div class="form-group">
            <label>Card Number</label>
            <input type="text" class="form-control" placeholder="1234 5678 9012 3456" required>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Expiry Date</label>
                    <input type="text" class="form-control" placeholder="MM/YY" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>CVV</label>
                    <input type="text" class="form-control" placeholder="123" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Pay Now</button>
    </form>
</div>

<?php include('includes/footer.php');?>
</body>
</html>
