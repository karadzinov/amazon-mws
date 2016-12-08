<?php
// Create connection



$dbhost							= "localhost";
$dbuser							= "amazon";
$dbpass							= "jsrPR7tZ";
$dbname							= "amazon";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Error connecting to database");
mysql_select_db($dbname);


$con=mysqli_connect("localhost","amazon","jsrPR7tZ","amazon");

// Check connection
if (mysqli_connect_errno($con))
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

  /* notes 
Seller account identifiers for Performance Brakes
Seller ID:	A3TLBT0BS42HFK
Marketplace ID:	ATVPDKIKX0DER
Developer account identifier and credentials for developer account number 0799-8694-2321*
AWS Access Key ID:	AKIAIUBT224ANUNW44OA
Secret Key:	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


  */
require_once("functions.php");

?>