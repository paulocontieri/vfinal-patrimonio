<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['vendorDetailsStatus'])){
		
		$fullName = htmlentities($_POST['vendorDetailsVendorFullName']);
		$email = htmlentities($_POST['vendorDetailsVendorEmail']);
		$mobile = htmlentities($_POST['vendorDetailsVendorMobile']);
		//$phone2 = htmlentities($_POST['vendorDetailsVendorPhone2']);
		//$address = htmlentities($_POST['vendorDetailsVendorAddress']);
		//$address2 = htmlentities($_POST['vendorDetailsVendorAddress2']);
		//$city = htmlentities($_POST['vendorDetailsVendorCity']);
		$district = htmlentities($_POST['vendorDetailsVendorDistrict']);
		$status = htmlentities($_POST['vendorDetailsStatus']);
	
		if(isset($fullName)) {
			// Validate mobile number
			if(filter_var($mobile, FILTER_VALIDATE_INT) === 0 || filter_var($mobile, FILTER_VALIDATE_INT)) {
				// Valid mobile number
			} else {
				// Mobile is wrong
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid phone number.</div>';
				exit();
			}
			
			
			// Start the insert process
			$sql = 'INSERT INTO vendor(fullName, email, mobile, district, status) VALUES(:fullName, :email, :mobile, :district, :status)';
			$stmt = $conn->prepare($sql);
			$stmt->execute(['fullName' => $fullName, 'email' => $email, 'mobile' => $mobile, 'district' => $district, 'status' => $status]);
			echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Vendor added to database</div>';
		} else {
			// One or more fields are empty
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	
	}
?>