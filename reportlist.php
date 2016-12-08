<?php
require_once 'header.php'; 
require_once 'paginate.php'; 


// $dbquery = mysqli_query($con, "SELECT * FROM reports ORDER BY id DESC");
echo '
<div class="row">
	<div class="col-sm-4" style="float: right">
		<form action="report.php" method="get" role="form" class="form-inline">
			<laber for="reportID">Report Id: </label>
				<input type="text" id="reportID" name="id" class="form-control">
				<button type="submit" class="btn btn-default btn-sm" stype="float: left;">Get Report</button>
			</form>
		</div>
	</div>
	';

	echo '<table class="table table-hover table-bordered tablesorter" id="rTable">
	<thead>
		<tr>
			<th>File Name</th>
			<th>Report Id</th>
			<th>Status</th>
			<th>Date Created</th>
			<th>File with Errors</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		';

		while ($row = mysql_fetch_array($result)) {
			$id = $row['rid'];
			$AmazonOrderID = $row['AmazonOrderID'];

			$exported = $row['exported'];


			if($exported == '1') {
				$button = '<a href="report.php?id='.$id.'" class="btn btn-success btn-sm">Exported to SBC</a>';
			}
			else {
				$button = '<a href="export.php?id='.$id.'" class="btn btn-danger btn-sm">Not exported</a>';
			}


			$datetime = new DateTime($row['date']);
			$date = $datetime->format('m-d-Y - g:i:s a');

			$state_status = $row['spt_State'];

			if(strlen($state_status) > 2) {
				$tr = "danger";
				$status = "!";
			}
			else {
				$tr = "default";
				$status = "ok";
			}

			$file = 'PO-' . $row['TrackNum'] . '.xml'; 
			echo '<tr class="'.$tr.'">
			<td><a href="files/xml/'.$file.'" target="_blank" class="btn btn-default btn-sm">'.$file.'</a></td>

			<td><a href="files/original/'.$id.'.xml" class="btn btn-info btn-sm" target="_blank">'.$id.'</a></td>
			<td>'.$button.'</td>
			<td>'.$date.'</td>
			<td>'.$status.'</td>
			<td><a href="reports.php?id='.$id.'" class="btn btn-default btn-sm"> View Original </a> <a href="editreport.php?id='.$id.'" class="btn btn-warning btn-sm"> Edit </a></td>
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
		$("#rTable").tablesorter(); 
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

