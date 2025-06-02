-- Add license verification fields to tblusers
ALTER TABLE tblusers
ADD COLUMN LicenseImagePath VARCHAR(255) NULL AFTER Country,
ADD COLUMN IsLicenseVerified TINYINT(1) DEFAULT 0 AFTER LicenseImagePath,
ADD COLUMN LicenseVerificationDate TIMESTAMP NULL AFTER IsLicenseVerified;
