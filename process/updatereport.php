<?php
require_once '../config/conf.php'; 

$rid = $_POST['rid'];


$TrackNum = $_POST['TrackNum'];
$CustomerID = $_POST['CustomerID'];
$Password = $_POST['Password'];
$SellingStore = $_POST['SellingStore'];
$PONum = $_POST['PONum'];
$CancelOrderFlag = $_POST['CancelOrderFlag'];
$JobNumber = $_POST['JobNumber'];
$UseSellPrice = $_POST['UseSellPrice'];
$ItemID = $_POST['ItemID'];
$MfgCode = $_POST['MfgCode'];
$PartNum = $_POST['PartNum'];
$Qty = $_POST['Qty'];
$QtyOrder = $_POST['QtyOrder'];
$SellPrice = $_POST['SellPrice'];
$spt_CompanyName = $_POST['spt_CompanyName'];
$spt_LastName = $_POST['spt_LastName'];
$spt_Street = $_POST['spt_Street'];
$spt_City = $_POST['spt_City'];
$spt_State = $_POST['spt_State'];
$spt_ZipCode = $_POST['spt_ZipCode'];
$spt_Phone = $_POST['spt_Phone'];
$spt_ResidentialDelivery = $_POST['spt_ResidentialDelivery'];
$ShipVia = $_POST['ShipVia'];


if(isset($TrackNum) && $TrackNum != NULL) {

	$query = mysqli_query($con, "UPDATE reports SET TrackNum = '$TrackNum' WHERE rid = '$rid'");
}
if(isset($CustomerID) && $CustomerID != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET CustomerID = '$CustomerID' WHERE rid = '$rid'");
}
if(isset($Password) && $Password != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET Password = '$Password' WHERE rid = '$rid'");
}
if(isset($SellingStore) && $SellingStore != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET SellingStore = '$SellingStore' WHERE rid = '$rid'");
}
if(isset($PONum) && $PONum != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET PONum = '$PONum' WHERE rid = '$rid'");
}
if(isset($CancelOrderFlag) && $CancelOrderFlag != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET CancelOrderFlag = '$CancelOrderFlag' WHERE rid = '$rid'");
}
if(isset($JobNumber) && $JobNumber != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET JobNumber = '$JobNumber' WHERE rid = '$rid'");
}
if(isset($UseSellPrice) && $UseSellPrice != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET UseSellPrice = '$UseSellPrice' WHERE rid = '$rid'");
}
if(isset($ItemID) && $ItemID != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET ItemID = '$ItemID' WHERE rid = '$rid'");
}
if(isset($MfgCode) && $MfgCode != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET MfgCode = '$MfgCode' WHERE rid = '$rid'");
}
if(isset($PartNum) && $PartNum != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET PartNum = '$PartNum' WHERE rid = '$rid'");
}
if(isset($Qty) && $Qty != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET Qty = '$Qty' WHERE rid = '$rid'");
}

if(isset($QtyOrder) && $QtyOrder != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET QtyOrder = '$QtyOrder' WHERE rid = '$rid'");
}
if(isset($SellPrice) && $SellPrice != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET SellPrice = '$SellPrice' WHERE rid = '$rid'");
}
if(isset($spt_CompanyName) && $spt_CompanyName != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET spt_CompanyName = '$spt_CompanyName' WHERE rid = '$rid'");
}
if(isset($spt_LastName) && $spt_LastName != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET spt_LastName = '$spt_LastName' WHERE rid = '$rid'");
}
if(isset($spt_Street) && $spt_Street != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET spt_Street = '$spt_Street' WHERE rid = '$rid'");
}
if(isset($spt_City) && $spt_City != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET spt_City = '$spt_City' WHERE rid = '$rid'");
}
if(isset($spt_State) && $spt_State != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET spt_State = '$spt_State' WHERE rid = '$rid'");
}
if(isset($spt_ZipCode) && $spt_ZipCode != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET spt_ZipCode = '$spt_ZipCode' WHERE rid = '$rid'");
}
if(isset($spt_Phone) && $spt_Phone != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET spt_Phone = '$spt_Phone' WHERE rid = '$rid'");
}

if(isset($spt_ResidentialDelivery) && $spt_ResidentialDelivery != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET spt_ResidentialDelivery = '$spt_ResidentialDelivery' WHERE rid = '$rid'");
}
if(isset($ShipVia) && $ShipVia != NULL) {
	$query = mysqli_query($con, "UPDATE reports SET ShipVia = '$ShipVia' WHERE rid = '$rid'");
}


 header('Location: ../report.php?id='.$rid.'');

?>




