<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	if(isset($_POST['purchaseDetailsItemNumber'])){

		$purchaseDetailsItemNumber = htmlentities($_POST['purchaseDetailsItemNumber']);
		$purchaseDetailsPurchaseDate = htmlentities($_POST['purchaseDetailsPurchaseDate']);
		$purchaseDetailsItemName = htmlentities($_POST['purchaseDetailsItemName']);
		//$purchaseDetailsQuantity = htmlentities($_POST['purchaseDetailsQuantity']);
		//$purchaseDetailsUnitPrice = htmlentities($_POST['purchaseDetailsUnitPrice']);
		$purchaseDetailsVendorName = htmlentities($_POST['purchaseDetailsVendorName']);
		
		
		// Check if mandatory fields are not empty
		if(isset($purchaseDetailsItemNumber) && isset($purchaseDetailsPurchaseDate) && isset($purchaseDetailsItemName)){
			
			// Check if itemNumber is empty
			if($purchaseDetailsItemNumber == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Item Number.</div>';
				exit();
			}
			
			// Check if itemName is empty
			if($purchaseDetailsItemName == ''){ 
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Item Name.</div>';
				exit();
			}
			
			// Sanitize item number
			$purchaseDetailsItemNumber = filter_var($purchaseDetailsItemNumber, FILTER_SANITIZE_STRING);
			
			
			// Check if the item exists in item table and 
			// calculate the stock values and update to match the new purchase quantity
			$stockSql = 'SELECT stock FROM item WHERE itemNumber=:itemNumber';
			$stockStatement = $conn->prepare($stockSql);
			$stockStatement->execute(['itemNumber' => $purchaseDetailsItemNumber]);
			if($stockStatement->rowCount() > 0){
				
				// Get the vendorId for the given vendorName
				$vendorIDsql = 'SELECT * FROM vendor WHERE fullName = :fullName';
				$vendorIDStatement = $conn->prepare($vendorIDsql);
				$vendorIDStatement->execute(['fullName' => $purchaseDetailsVendorName]);
				$row = $vendorIDStatement->fetch(PDO::FETCH_ASSOC);
				$vendorID = $row['vendorID'];
				
				// Item exits in the item table, therefore, start the inserting data to purchase table
				$insertPurchaseSql = 'INSERT INTO purchase(itemNumber, purchaseDate, itemName, vendorName, vendorID) VALUES(:itemNumber, :purchaseDate, :itemName, :vendorName, :vendorID)';
				$insertPurchaseStatement = $conn->prepare($insertPurchaseSql);
				$insertPurchaseStatement->execute(['itemNumber' => $purchaseDetailsItemNumber, 'purchaseDate' => $purchaseDetailsPurchaseDate, 'itemName' => $purchaseDetailsItemName, 'vendorName' => $purchaseDetailsVendorName, 'vendorID' => $vendorID]);
				
				echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Patrimônio alocado ao Responsável escolhido</div>';
				exit();
				
			} else {
				// Item does not exist in item table, therefore, you can't make a purchase from it 
				// to add it to DB as a new purchase
				echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item does not exist in DB. Therefore, first enter this item to DB using the <strong>Item</strong> tab.</div>';
				exit();
			}

		} else {
			// One or more mandatory fields are empty. Therefore, display a the error message
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
			exit();
		}
	}
?>