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

if(!$booking) {
    header('location:my-booking.php');
    exit();
}

// Get vehicle details and total amount
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

// Update booking status to "Paid" (Status=3)
$sql = "UPDATE tblbooking SET Status=3 WHERE id=:bid";
$query = $dbh->prepare($sql);
$query->bindParam(':bid', $bookingId, PDO::PARAM_INT);
$query->execute();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>CarForYou - Payment Successful</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/payment.css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
<?php include('includes/header.php');?>

<div class="container payment-success-container">
    <div class="success-message">
        <h2><i class="fa fa-check-circle"></i> Payment Successful</h2>
        <p>Your payment for Booking #<?php echo $booking->id; ?> has been processed successfully.</p>
        
        <div class="booking-details">
            <h4>Booking Summary</h4>
            <p>Vehicle: <?php echo htmlentities($vehicle->BrandName.' '.$vehicle->VehiclesTitle); ?></p>
            <p>Dates: <?php echo htmlentities($booking->FromDate.' to '.$booking->ToDate); ?></p>
            <p>Price per day: ₹<?php echo htmlentities($vehicle->PricePerDay); ?></p>
            <p>Total days: 4</p>
            <h5>Total Paid: ₹<?php echo htmlentities($vehicle->total); ?></h5>
            <p>Status: Paid</p>
        </div>
        
        <a href="my-booking.php" class="btn btn-primary">View My Bookings</a>
    </div>
</div>

<?php include('includes/footer.php');?>
</body>
</html>
