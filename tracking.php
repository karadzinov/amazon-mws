<?php
require_once 'header.php'; 
require_once 'paginate_tracking.php'; 



echo '<table class="table table-hover table-bordered tablesorter" id="tTable">
<thead>
	<tr>
		<th>OrderId (order_id)</th>
		<th>Order Item Id (order_item_id)</th>
		<th>Account Number</th>
		<th>Quantity (quantity)</th>
		<th>Ship Date (ship_date)</th>
		<th>Carrier Code (carrier_code)</th>
		<th>Carrier Name (carrier_name)</th>
		<th>Tracking Number (tracking_number)</th>
		<th>Ship Method (ship-method)</th>
		<th>Exported</th>
	</tr>
</thead>
<tbody>
	';

	while ($row = mysql_fetch_array($result)) {
		$id = $row['id'];

		$tracking = $row['tracking_number'];


		if($tracking != NULL) {
			$button = '<a href="" class="btn btn-info btn-sm">'.$tracking.'</a>';
		}
		else {
			$button = '
			<form action="/process/addtracking.php" method="post">
				<div class="form-group">
					<div class="col-xs-12">
						<input class="form-control input-sm" type="text" placeholder="Enter tracking number" name="tracking">
						<input type="hidden" name="id" value="'.$id.'" >
						<input type="hidden" name="order_id" value="'.$row['order_id'].'" >
						<br />
						<button type="submit" class="btn btn-success btn-sm"> Add Tracking </button></div>
					</div>
				</form>';
			}


			$datetime = new DateTime($row['ship_date']);
			$date = $datetime->format('Y-m-d');

			if($row['exported'] == '1') {
				$exported = '<p class="btn btn-success">Updated</p>';
			}
			else {
				$exported = '<p class="btn btn-danger">Not updated</p>';
			}


			echo '
			<tr>
				<td>'.$row['order_id'].'</td>
				<td>'.$row['order_item_id'].'</td>
				<td>'.$row['bi_CustomerID'].'</td>
				<td>'.$row['quantity'].'</td>
				<td>'.$date.'</td>
				<td>'.$row['carrier_code'].'</td>
				<td>'.$row['carrier_name'].'</td>
				<td>'.$button.'</td>
				<td>'.$row['ship-method'].'</td>
				<td>'.$exported.'</td>
			</tr>
			';
		}


		echo '
	</tbody>
</table>
';


echo '<div class="clearfix"><br /></div><div style="text-align: center">' . $paginate . '</div>';


echo '
<script>
	$(function() 
	{ 
		$("#tTable").tablesorter(); 
	} 
	); 
</script>


<script>
	$(document).ready(function() {
		$("table").filterTable();
	});
</script>


';

require_once 'footer.php'; 

?>

