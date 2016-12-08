<?php 
require_once 'header.php'; 

$id = $_GET['id'];

$xml = GetReport("GetReport", $id);

$reportID = $xml->Message;


foreach ($reportID as $reportIDkey) {


	$AmazonOrderID = $reportIDkey->OrderReport->AmazonOrderID;

	$items = $reportIDkey->OrderReport->Item;
	$i = 1;
	foreach ($items as $item) {
		$itemID = $i;
		$MfgCode = substr($item->SKU, 0, 3);
		$PartNum = substr($item->SKU, 3);
		$Qty = $item->Quantity;
		$QtyOrder = $item->Quantity;
		$SellPrice = $item->ItemPrice->Component->Amount;
		$i++;
		$itemdb = mysqli_query($con, "INSERT INTO items (ItemID, MfgCode, PartNum, Qty, QtyOrder, SellPrice, reportID) VALUES ('$itemID', '$MfgCode', '$PartNum', '$Qty', '$QtyOrder', '$SellPrice', '$AmazonOrderID')");
	}


	$sku = substr($reportIDkey->OrderReport->Item->SKU, 0, 3);
	$partnum = substr($reportIDkey->OrderReport->Item->SKU, 3);
	$companyname = $reportIDkey->OrderReport->FulfillmentData->Address->Name;
	$addr = $reportIDkey->OrderReport->FulfillmentData->Address->AddressFieldOne;
	$address2 = $reportIDkey->OrderReport->FulfillmentData->Address->AddressFieldTwo;
	$address = substrwords($addr, 25, '');
	$i = strlen($address);
	$lastname = substr($addr, $i, 30000);
	if($address2 != "") {
		$lastname .= " ".$address2;
	}

	if($sku == "APE" || $sku == "APK") {
		$customerId = "APD1001";
	}
	else if($sku == "DMB") {
		$customerId = "APD1007-1";
	}
	else {
		$customerId = "error";
	}


	$AmazonOrderItemCode = $reportIDkey->OrderReport->Item->AmazonOrderItemCode;
	$tracknum = explode("-", $reportIDkey->OrderReport->AmazonOrderID);
	$tnum = $tracknum[0]. "-". $tracknum[1];
	$jobnumber = "-".$tracknum[2];
	$quantity = $reportIDkey->OrderReport->Item->Quantity;
	$price = $reportIDkey->OrderReport->Item->ItemPrice->Component->Amount;
	$city = $reportIDkey->OrderReport->FulfillmentData->Address->City;
	$state = $reportIDkey->OrderReport->FulfillmentData->Address->StateOrRegion;
	$state = state_code($state);
	$zipcode = $reportIDkey->OrderReport->FulfillmentData->Address->PostalCode;
	$phone = $reportIDkey->OrderReport->FulfillmentData->Address->PhoneNumber;


	$query = mysqli_query($con,"SELECT AmazonOrderID FROM reports WHERE AmazonOrderID = '$AmazonOrderID'");
	if (!($row = mysqli_fetch_array($query))) {
		$dbquery = mysqli_query($con, "INSERT INTO reports 
			(TrackNum, bi_CustomerID, bi_Password, SellingStore, PONum, CancelOrderFlag, JobNumber, UseSellPrice, ItemID, MfgCode, PartNum, Qty, QtyOrder, SellPrice, sdt_CompanyName, sdt_Street, sdt_City, sdt_State, sdt_ZipCode, sdt_Phone, spt_CompanyName, spt_LastName, spt_Street, spt_City, spt_State, spt_ZipCode, spt_Phone, spt_ResidentialDelivery, ShipVia,  rid, AmazonOrderID, AmazonOrderItemCode) 
			VALUES 
			('$tnum', '$customerId', '9265', '1', '$tnum', 'N','$jobnumber', 'Y', '1','$sku', '$partnum','$quantity','$quantity', '$price', 'VELESTRUMF','501 CRANBROOK','LOCKPORT', 'IL','60333','6302061166','$companyname','$lastname','$address', '$city', '$state', '$zipcode', '$phone','Y','F','$id', '$AmazonOrderID', '$AmazonOrderItemCode')");
		$dbquery_update = mysqli_query($con, "UPDATE reportlist SET status = '1' WHERE ReportId = '$id'");
		$tquery = mysqli_query($con, "INSERT INTO tracking (order_id, order_item_id, quantity) VALUES ('$AmazonOrderID','$AmazonOrderItemCode','$quantity')");
		export($AmazonOrderID);
	}




	echo "<pre>";
	echo "TrackNum: ". $tnum. "<br />";
	echo "CostumerID: ". $customerId. "<br />";
	echo "Password: 9265 <br />";
	echo "SellingStore: 1 <br />";
	echo "PONum: ". $tnum. "<br />";
	echo "CancelOrderFlag: N <br />";
	echo "JobNumber: ". $jobnumber ."<br />";
	echo "UseSellPrice: Y <br />";

	$getitems = mysqli_query($con, "SELECT * FROM reports INNER JOIN items ON reports.AmazonOrderID = items.reportID WHERE reports.AmazonOrderID = '$AmazonOrderID' ORDER BY items.ItemID ASC");
	if($check = mysqli_fetch_array($getitems)) {
		while($row = mysqli_fetch_array($getitems)) {
			echo "ItemID: ".$row['ItemID']." <br />";
			echo "MfgCode: ".$row['MfgCode']." <br />";
			echo "PartNum: ".$row['PartNum']. "<br />";
			echo "Quantity: ". $row['Qty'] ." <br />";
			echo "QtyOrder: ". $row['QtyOrder'] ." <br />";
			echo "SellPrice: ". $row['SellPrice'] . "<br />";
		}
	}
	else {
		echo "ItemID: 1 <br />";
		echo "MfgCode: ".$sku." <br />";
		echo "PartNum: ".$partnum. "<br />";
		echo "Quantity: ". $quantity ." <br />";
		echo "QtyOrder: ". $quantity ." <br />";
		echo "SellPrice: ". $price . "<br />";
	}

	echo "---- SoldTo ----<br />";
	echo "CompanyName: VELESTRUMF <br />";
	echo "Street: 501 CRANBROOK <br />";
	echo "City: LOCKPORT <br />";
	echo "State: IL <br />";
	echo "ZipCode: 60333 <br />";
	echo "Phone: 6302061166 <br />";
	echo "----------------<br />";
	echo "---- ShipTo ---- <br />";
	echo "CompanyName: ".$companyname."<br />";
	echo "LastName: ".$lastname."<br />";
	echo "Street: ".$address."<br />";
	echo "City: ".$city."<br />";
	echo "State: ".$state."<br />";
	echo "ZipCode: ".$zipcode."<br />";
	echo "Phone: ".$phone."<br />";
	echo "ResidentialDelivery: Y<br />";
	echo "----------------<br />";
	echo "ShipVia: F<br />";
	echo "</pre>";

}

/*
echo "<pre>";
print_r($xml);
echo "</pre>";
*/
require_once 'footer.php'; 

?>