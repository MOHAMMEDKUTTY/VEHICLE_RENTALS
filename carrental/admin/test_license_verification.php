<?php
session_start();
include('includes/config.php');

// Test data - use an existing user ID from your database
$testUserId = 1; 

// 1. Check current verification status
$sql = "SELECT LicenseImagePath, IsLicenseVerified, LicenseVerificationDate 
        FROM tblusers WHERE id = :id";
$query = $dbh->prepare($sql);
$query->bindParam(':id', $testUserId, PDO::PARAM_INT);
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);

echo "Current Status:\n";
print_r($user);

// 2. Simulate verification
$updateSql = "UPDATE tblusers SET 
              IsLicenseVerified = 1,
              LicenseVerificationDate = NOW()
              WHERE id = :id";
$updateQuery = $dbh->prepare($updateSql);
$updateQuery->bindParam(':id', $testUserId, PDO::PARAM_INT);

if($updateQuery->execute()) {
    echo "\nVerification Update Successful\n";
    
    // 3. Verify the update
    $verifyQuery = $dbh->prepare("SELECT IsLicenseVerified, LicenseVerificationDate 
                                FROM tblusers WHERE id = :id");
    $verifyQuery->bindParam(':id', $testUserId, PDO::PARAM_INT);
    $verifyQuery->execute();
    $updatedUser = $verifyQuery->fetch(PDO::FETCH_ASSOC);
    
    echo "Updated Status:\n";
    print_r($updatedUser);
} else {
    echo "\nVerification Update Failed\n";
    print_r($dbh->errorInfo());
}
?>
