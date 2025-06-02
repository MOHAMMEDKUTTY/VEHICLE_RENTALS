<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {    
    header('location:index.php');
} else {
    if(isset($_GET['id']) && isset($_GET['status'])) {
        $id = $_GET['id'];
        $status = $_GET['status'];
        
        // Update license verification status
        $sql = "UPDATE tblusers SET 
                IsLicenseVerified = :status,
                LicenseVerificationDate = NOW()
                WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_INT);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        
        if($query->execute()) {
            // Debug logging
            error_log("License verification updated - ID: $id, Status: $status");
            $_SESSION['msg'] = "License verification status updated successfully";
            
            // Verify the update
            $check = $dbh->prepare("SELECT IsLicenseVerified FROM tblusers WHERE id = :id");
            $check->bindParam(':id', $id, PDO::PARAM_INT);
            $check->execute();
            $result = $check->fetch(PDO::FETCH_ASSOC);
            error_log("Verification check - Current status: " . $result['IsLicenseVerified']);
        } else {
            error_log("License verification failed - ID: $id");
            $_SESSION['error'] = "Failed to update license verification status";
        }
        
        header('location:reg-users.php');
    } else {
        header('location:reg-users.php');
    }
}
?>
