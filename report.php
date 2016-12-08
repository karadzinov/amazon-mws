<?php

require_once 'header.php';
echo '<a href="reportlist.php" class="btn btn-default">Back</a><br /><br /><div class="clearfix"></div>';
$id = $_GET['id'];
$dbquery = mysqli_query($con, "SELECT * FROM reports WHERE rid = '$id'");



while ($row = mysqli_fetch_array($dbquery)) {
$AmazonOrderID = $row['AmazonOrderID'];
	echo "<pre>Report Name: PO-" . $row['TrackNum'] . ".xml</pre>";


	$xmlfile = '<?xml version="1.0" encoding="utf-8" ?>
	<SBCPartOrderRequest>
		<TrackingInfo>
			<TrackNum>' . $row['TrackNum'] . '</TrackNum>
		</TrackingInfo>
		<BuyerInfo>
			<CustomerID>' . $row['bi_CustomerID'] . '</CustomerID>
			<Password>' . $row['bi_Password'] . '</Password>
		</BuyerInfo>
		<SellingStore>' . $row['SellingStore'] . '</SellingStore>
		<PONum>' . $row['PONum'] . '</PONum>
		<CancelOrderFlag>' . $row['CancelOrderFlag'] . '</CancelOrderFlag>
		<JobNumber>' . $row['JobNumber'] . '</JobNumber>
		<UseSellPrice>' . $row['UseSellPrice'] . '</UseSellPrice>
		<Items>
			<Item>';

			$checkitems = mysqli_query($con, "SELECT * FROM reports INNER JOIN items ON reports.AmazonOrderID = items.reportID WHERE reports.AmazonOrderID = '$AmazonOrderID' ORDER BY items.ItemID ASC");
				$getitems = mysqli_query($con, "SELECT * FROM reports INNER JOIN items ON reports.AmazonOrderID = items.reportID WHERE reports.AmazonOrderID = '$AmazonOrderID' ORDER BY items.ItemID ASC");
				if($check = mysqli_fetch_array($checkitems)) {
					while ($row = mysqli_fetch_array($getitems)) {
						$item .= '
						<ItemID>' . $row['ItemID'] . '</ItemID>
						<MfgCode>' . $row['MfgCode'] . '</MfgCode>
						<PartNum>' . $row['PartNum'] . '</PartNum>
						<Qty>' . $row['Qty'] . '</Qty>
						<QtyOrder>' . $row['QtyOrder'] . '</QtyOrder>
						<SellPrice>' . $row['SellPrice'] . '</SellPrice>';
					}
				}
				else {
					$item = '
					<ItemID>' . $row['ItemID'] . '</ItemID>
					<MfgCode>' . $row['MfgCode'] . '</MfgCode>
					<PartNum>' . $row['PartNum'] . '</PartNum>
					<Qty>' . $row['Qty'] . '</Qty>
					<QtyOrder>' . $row['QtyOrder'] . '</QtyOrder>
					<SellPrice>' . $row['SellPrice'] . '</SellPrice>';
				}

				$xmlfile .= $item;

				$xmlfile .= '
			</Item>
		</Items>
		<SoldTo>
			<CompanyName>' . $row['sdt_CompanyName'] . '</CompanyName>
			<Street>' . $row['sdt_Street'] . '</Street>
			<City>' . $row['sdt_City'] . '</City>
			<State>' . $row['sdt_State'] . '</State>
			<ZipCode>' . $row['sdt_ZipCode'] . '</ZipCode>
			<Phone>' . $row['sdt_Phone'] . '</Phone>
		</SoldTo>
		<ShipTo>
			<CompanyName>' . $row['spt_CompanyName'] . '</CompanyName>
			<LastName>' . $row['spt_LastName'] . '</LastName>
			<Street>' . $row['spt_Street'] . '</Street>
			<City>' . $row['spt_City'] . '</City>
			<State>' . $row['spt_State'] . '</State>
			<ZipCode>' . $row['spt_ZipCode'] . '</ZipCode>
			<Phone>' . $row['spt_Phone'] . '</Phone>
			<ResidentialDelivery>' . $row['spt_ResidentialDelivery'] . '</ResidentialDelivery>
		</ShipTo>
		<ShipVia>' . $row['ShipVia'] . '</ShipVia>
	</SBCPartOrderRequest>
	';


	echo "<pre>".$xmlfile."</pre>";
	$file = 'PO-' . $row['TrackNum'] . '.xml'; 

	echo $file."<br />";

	//touch('files/xml'.$file);
	/* and finally, put the contents */ 
	file_put_contents('files/xml/'.$file, $xmlfile);


$ftp_server = '173.9.236.179';
$ftp_user_name = 'martin';
$ftp_user_pass = 'temp12345';

$fp = fopen('files/xml/'.$file, 'r');


// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

$filepath = '/sbc/amazon/inbound/'.$file;

// try to upload $file
if (ftp_fput($conn_id, $filepath, $fp, FTP_BINARY)) {

    $query = mysqli_query($con, "UPDATE reports SET exported = '1' WHERE rid = '$id'");
        echo "Successfully uploaded $file\n";
} else {
    echo "There was a problem while uploading $file\n";
}

// close the connection and the file handler
ftp_close($conn_id);
fclose($fp);

$ftp_server = '173.9.236.179';
$ftp_user_name = 'martin';
$ftp_user_pass = 'temp12345';

$fp = fopen('files/xml/'.$file, 'r');


// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
$filepath_sec = '/sbc/amazon/inbound/archive/'.$file;

if (ftp_fput($conn_id, $filepath_sec, $fp, FTP_BINARY)) {

        echo "Successfully uploaded $file\n";
} else {
    echo "There was a problem while uploading $file\n";
}

// close the connection and the file handler
ftp_close($conn_id);
fclose($fp);



}

require_once 'footer.php';
?>