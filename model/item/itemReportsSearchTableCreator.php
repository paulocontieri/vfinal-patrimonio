<?php
	require_once('../../inc/config/constants.php');
	require_once('../../inc/config/db.php');
	
	$itemDetailsSearchSql = 'SELECT item.*, purchase.vendorName 
	FROM `item` 
	LEFT JOIN purchase ON purchase.itemNumber = item.itemNumber;';
	$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
	$itemDetailsSearchStatement->execute();

	$output = '<table id="itemReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Etiqueta</th>
						<th>Patrimônio</th>
						<th>Status</th>
						<th>Descrição</th>
						<th>Responsável</th>
					</tr>
				</thead>
				<tbody>';
				
	
	// Create table rows from the selected data
	while($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)){
		$output .= '<tr>' .
						'<td>' . $row['productID'] . '</td>' .
						'<td>' . $row['itemNumber'] . '</td>' .
						//'<td>' . $row['itemName'] . '</td>' .
						'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['productID'] . '">' . $row['itemName'] . '</a></td>' .
						'<td>' . $row['status'] . '</td>' .
						'<td>' . $row['description'] . '</td>' ;

						if (empty($row['vendorName'])){
							$output .=	'<td style="color:green;font-weight: bold">' .'Disponível'. '</td>' ;
						} else {
							$output .=	'<td>' . $row['vendorName'] . '</td>' ;
						}				
					'</tr>';
	}
	
	$itemDetailsSearchStatement->closeCursor();
	
	$output .= '</tbody>
					<tfoot>
						<tr>
						<th>ID</th>
						<th>Etiqueta</th>
						<th>Patrimônio</th>
						<th>Status</th>
						<th>Descrição</th>
						<th>Local/Responsável</th>
						
						</tr>
					</tfoot>
				</table>';
	echo $output;
?>