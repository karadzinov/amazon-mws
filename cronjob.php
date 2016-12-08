<?php
require_once 'config/conf.php'; 
$xml = GetReportList("GetReportList");
$reportID = $xml->GetReportListResult->ReportInfo;

foreach ($reportID as $reportIDkey) {
	$dbquery = mysqli_query($con,"SELECT ReportRequestId FROM reportlist WHERE ReportRequestId = '$reportIDkey->ReportRequestId' AND ReportType != '_GET_FLAT_FILE_ORDERS_DATA_' AND ReportType != '_GET_FLAT_FILE_PAYMENT_SETTLEMENT_DATA_'");
	if (!($row = mysqli_fetch_array($dbquery))) {
		$dbquery = mysqli_query($con,"INSERT INTO reportlist (ReportId, ReportType, ReportRequestId, AvailableDate, Acknowledged, AcknowledgedDate) 
			VALUES ('$reportIDkey->ReportId', '$reportIDkey->ReportType', '$reportIDkey->ReportRequestId', '$reportIDkey->AvailableDate', '$reportIDkey->Acknowledged', '$reportIDkey->AcknowledgedDate' )");
	}
}

$query = mysqli_query($con, "SELECT * FROM reportlist WHERE status = '0' AND ReportType != '_GET_FLAT_FILE_ORDERS_DATA_' AND ReportType != '_GET_FLAT_FILE_PAYMENT_SETTLEMENT_DATA_'");
while ($row = mysqli_fetch_array($query)) {
	$id = $row['ReportId'];
	$status = report($id);
	if ($status == "ok") {
		$status = "Success for ReportId: ".$id." Date: ".date("Y-m-d H:i:s")."<br />";
		sleep(2);
	}
	else {
		$status = "Error for ReportId: ".$id." Date: ".date("Y-m-d H:i:s")."<br />";
	}
}
echo $status;
$gettracking = getTracking("go");
echo $gettracking;
$update_tracking = update_tracking('update');
echo $update_tracking;

?>

