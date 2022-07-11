<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');

	
	$purchaseDetailsSearchSql = 'SELECT * FROM purchase';
	$purchaseDetailsSearchStatement = $conn->prepare($purchaseDetailsSearchSql);
	$purchaseDetailsSearchStatement->execute();

	$output = '<table id="purchaseReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Etiqueta</th>
						<th>Patrimônio</th>
						<th>Data de alocação</th>
						<th>Local/Responsável</th>
					</tr>
				</thead>
				<tbody>';
	
	// Create table rows from the selected data
	while($row = $purchaseDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$uPrice = $row['unitPrice'];
		$qty = $row['quantity'];
		$totalPrice = $uPrice * $qty;
		
		$output .= '<tr>' .
						'<td>' . $row['purchaseID'] . '</td>' .
						'<td>' . $row['itemNumber'] . '</td>' .
						'<td>' . $row['itemName'] . '</td>' .
						'<td>' . $row['purchaseDate'] . '</td>' .
						'<td>' . $row['vendorName'] . '</td>' .
					'</tr>';
	}
	
	$purchaseDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
					<tr>
						<th>ID</th>
						<th>Etiqueta</th>
						<th>Patrimônio</th>
						<th>Data de alocação</th>
						<th>Local/Responsável</th>
					</tr>
					</tfoot>
				</table>';
	echo $output;
?>


