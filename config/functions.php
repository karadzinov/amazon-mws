<?php
function DB()
{
    $con = mysqli_connect("localhost", "amazon", "jsrPR7tZ", "amazon");
    return $con;
}

function GetReportList($getAction)
{

    define('DATE_FORMAT', 'Y-m-d\TH:i:s\Z');
    define('AWS_ACCESS_KEY_ID', 'AKIAIUBT224ANUNW44OA');
    define('AWS_SECRET_ACCESS_KEY', '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');
    define('APPLICATION_NAME', 'Performance Brakes App');
    define('APPLICATION_VERSION', '1');
    define("MERCHANT_ID", "A3TLBT0BS42HFK");
    define('DATE_FORMAT', 'Y-m-d\TH:i:s\Z');

    $AWSAccessKeyId = AWS_ACCESS_KEY_ID;
    $MerchantId = "A3TLBT0BS42HFK";
    $Action = $getAction;
    $secret = AWS_SECRET_ACCESS_KEY;

    $param = array(
        'AWSAccessKeyId' => $AWSAccessKeyId,
        'Acknowledged' => 'true',
        'Action' => $Action,
        'Merchant' => $MerchantId,
        'SignatureMethod' => 'HmacSHA256',
        'SignatureVersion' => '2',
        'Timestamp' => gmdate(DATE_FORMAT),
        'Version' => '2009-01-01'
    );

    $url = array();
    foreach ($param as $key => $val) {

        $key = str_replace("%7E", "~", rawurlencode($key));
        $val = str_replace("%7E", "~", rawurlencode($val));
        $url[] = "{$key}={$val}";
    }

    sort($url);

    $arr = implode('&', $url);

    $sign = 'POST' . "\n";
    $sign .= 'mws.amazonservices.com' . "\n";
    $sign .= '/' . "\n";
    $sign .= $arr;

    $signature = hash_hmac("sha256", $sign, $secret, true);
    $signature = urlencode(base64_encode($signature));
    $link = "https://mws.amazonservices.com/";
    $ch = curl_init($link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $arr . "&Signature=" . $signature);
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);


    $xml = simplexml_load_string($response);

    return $xml;

}


function GetReport($getAction, $ReportId)
{

    define('DATE_FORMAT', 'Y-m-d\TH:i:s\Z');
    define('AWS_ACCESS_KEY_ID', 'AKIAIUBT224ANUNW44OA');
    define('AWS_SECRET_ACCESS_KEY', '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');
    define('APPLICATION_NAME', 'Performance Brakes App');
    define('APPLICATION_VERSION', '1');
    define("MERCHANT_ID", "A3TLBT0BS42HFK");
    define('DATE_FORMAT', 'Y-m-d\TH:i:s\Z');

    $AWSAccessKeyId = AWS_ACCESS_KEY_ID;
    $MerchantId = "A3TLBT0BS42HFK";
    $Action = $getAction;
    $secret = AWS_SECRET_ACCESS_KEY;


    $param = array(
        'AWSAccessKeyId' => $AWSAccessKeyId,
        'Action' => $Action,
        'Merchant' => $MerchantId,
        'SignatureMethod' => 'HmacSHA256',
        'SignatureVersion' => '2',
        'Timestamp' => gmdate(DATE_FORMAT),
        'Version' => '2009-01-01',
        'ReportId' => $ReportId,
    );

    $url = array();
    foreach ($param as $key => $val) {

        $key = str_replace("%7E", "~", rawurlencode($key));
        $val = str_replace("%7E", "~", rawurlencode($val));
        $url[] = "{$key}={$val}";
    }

    sort($url);

    $arr = implode('&', $url);

    $sign = 'POST' . "\n";
    $sign .= 'mws.amazonservices.com' . "\n";
    $sign .= '/' . "\n";
    $sign .= $arr;

    $signature = hash_hmac("sha256", $sign, $secret, true);
    $signature = urlencode(base64_encode($signature));
    $link = "https://mws.amazonservices.com/";
    $ch = curl_init($link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $arr . "&Signature=" . $signature);
    $response = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);


    $xml = simplexml_load_string($response);

    file_put_contents('files/original/' . $ReportId . '.xml', $response);

    return $xml;

}


function spaceless_substr($string, $start, $count)
{
    return substr($string, $start, ($count + substr_count($string, ' ', $start, $count)));
}


function report($id)
{
    $con = mysqli_connect("localhost", "amazon", "jsrPR7tZ", "amazon");
    $xml = GetReport("GetReport", $id);

    $reportID = $xml->Message;


    foreach ($reportID as $reportIDkey) {
        $AmazonOrderID = $reportIDkey->OrderReport->AmazonOrderID;

        $items = $reportIDkey->OrderReport->Item;
        $i = 1;
        if (is_array($items)) {
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
        }

        $sku = substr($reportIDkey->OrderReport->Item->SKU, 0, 3);
        $partnum = substr($reportIDkey->OrderReport->Item->SKU, 3);
        $companyname = $reportIDkey->OrderReport->FulfillmentData->Address->Name;
        $addr = $reportIDkey->OrderReport->FulfillmentData->Address->AddressFieldOne;
        $address2 = $reportIDkey->OrderReport->FulfillmentData->Address->AddressFieldTwo;
        $address = substrwords($addr, 25, '');
        $i = strlen($address);
        $lastname = substr($addr, $i, 30000);
        if ($address2 != "") {
            $lastname .= " " . $address2;
        }

        if ($sku == "APE" || $sku == "APK") {
            $customerId = "APD1001";
        } else if ($sku == "DMB") {
            $customerId = "APD1007-1";
        } else {
            $customerId = "error";
        }


        $AmazonOrderItemCode = $reportIDkey->OrderReport->Item->AmazonOrderItemCode;
        $tracknum = explode("-", $reportIDkey->OrderReport->AmazonOrderID);
        $tnum = $tracknum[0] . "-" . $tracknum[1];
        $jobnumber = "-" . $tracknum[2];
        $quantity = $reportIDkey->OrderReport->Item->Quantity;
        $price = $reportIDkey->OrderReport->Item->ItemPrice->Component->Amount;
        $city = $reportIDkey->OrderReport->FulfillmentData->Address->City;
        $state = $reportIDkey->OrderReport->FulfillmentData->Address->StateOrRegion;
        $state = state_code($state);
        $zipcode = $reportIDkey->OrderReport->FulfillmentData->Address->PostalCode;
        $phone = $reportIDkey->OrderReport->FulfillmentData->Address->PhoneNumber;


        $query = mysqli_query($con, "SELECT AmazonOrderID FROM reports WHERE AmazonOrderID = '$AmazonOrderID'");
        if (!($row = mysqli_fetch_array($query))) {
            $dbquery = mysqli_query($con, "INSERT INTO reports 
				(TrackNum, bi_CustomerID, bi_Password, SellingStore, PONum, CancelOrderFlag, JobNumber, UseSellPrice, ItemID, MfgCode, PartNum, Qty, QtyOrder, SellPrice, sdt_CompanyName, sdt_Street, sdt_City, sdt_State, sdt_ZipCode, sdt_Phone, spt_CompanyName, spt_LastName, spt_Street, spt_City, spt_State, spt_ZipCode, spt_Phone, spt_ResidentialDelivery, ShipVia,  rid, AmazonOrderID, AmazonOrderItemCode) 
				VALUES 
				('$tnum', '$customerId', '9265', '1', '$tnum', 'N','$jobnumber', 'Y', '1','$sku', '$partnum','$quantity','$quantity', '$price', 'VELESTRUMF','501 CRANBROOK','LOCKPORT', 'IL','60333','6302061166','$companyname','$lastname','$address', '$city', '$state', '$zipcode', '$phone','Y','F','$id', '$AmazonOrderID', '$AmazonOrderItemCode')");
            $dbquery_update = mysqli_query($con, "UPDATE reportlist SET status = '1' WHERE ReportId = '$id'");
            $tquery = mysqli_query($con, "INSERT INTO tracking (order_id, order_item_id, quantity) VALUES ('$AmazonOrderID','$AmazonOrderItemCode','$quantity')");
            export($AmazonOrderID);
        }

    }
    return "ok";
}

function limit_text($text, $len)
{

    $space = strrpos($text, ' ');
    $text = substr($text, 0, $space);

    if (strlen($text) < $len) {
        return $text;
    }
    $text_words = explode(' ', $text);
    $out = null;


    foreach ($text_words as $word) {
        if ((strlen($word) > $len) && $out == null) {

            return substr($word, 0, $len);
        }
        if ((strlen($out) + strlen($word)) > $len) {
            return $out;
        }
        $out .= " " . $word;
    }
    return $out;
}

function substrwords($text, $maxchar, $end = '...')
{
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);
        $output = '';
        $i = 0;
        while (1) {
            $length = strlen($output) + strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } else {
        $output = $text;
    }
    return $output;
}


function state_code($i)
{

    $i = strtolower($i);

    if ($i === "alabama") {
        $state = "AL";
    } else if ($i === "alaska") {
        $state = "AK";
    } else if ($i === "arizona") {
        $state = "AZ";
    } else if ($i === "arkansas") {
        $state = "AR";
    } else if ($i === "california") {
        $state = "CA";
    } else if ($i === "colorado") {
        $state = "CO";
    } else if ($i === "connecticut") {
        $state = "CT";
    } else if ($i === "delaware") {
        $state = "DE";
    } else if ($i === "district of columbia") {
        $state = "DC";
    } else if ($i === "florida") {
        $state = "FL";
    } else if ($i === "georgia") {
        $state = "GA";
    } else if ($i === "hawaii") {
        $state = "HI";
    } else if ($i === "idaho") {
        $state = "ID";
    } else if ($i === "illinois") {
        $state = "IL";
    } else if ($i === "indiana") {
        $state = "IN";
    } else if ($i === "iowa") {
        $state = "IA";
    } else if ($i === "kansas") {
        $state = "KS";
    } else if ($i === "kentucky") {
        $state = "KY";
    } else if ($i === "louisiana") {
        $state = "LA";
    } else if ($i === "maine") {
        $state = "ME";
    } else if ($i === "maryland") {
        $state = "MD";
    } else if ($i === "massachusetts") {
        $state = "MA";
    } else if ($i === "michigan") {
        $state = "MI";
    } else if ($i === "minnesota") {
        $state = "MN";
    } else if ($i === "mississippi") {
        $state = "MS";
    } else if ($i === "missouri") {
        $state = "MO";
    } else if ($i === "montana") {
        $state = "MT";
    } else if ($i === "nebraska") {
        $state = "NE";
    } else if ($i === "nevada") {
        $state = "NV";
    } else if ($i === "new hampshire") {
        $state = "NH";
    } else if ($i === "new jersey") {
        $state = "NJ";
    } else if ($i === "new mexico") {
        $state = "NM";
    } else if ($i === "new york") {
        $state = "NY";
    } else if ($i === "north carolina") {
        $state = "NC";
    } else if ($i === "north dakota") {
        $state = "ND";
    } else if ($i === "ohio") {
        $state = "OH";
    } else if ($i === "oklahoma") {
        $state = "OK";
    } else if ($i === "oregon") {
        $state = "OR";
    } else if ($i === "pennsylvania") {
        $state = "PA";
    } else if ($i === "rhode island") {
        $state = "RI";
    } else if ($i === "south carolina") {
        $state = "SC";
    } else if ($i === "south dakot") {
        $state = "SD";
    } else if ($i === "tennessee") {
        $state = "TN";
    } else if ($i === "texas") {
        $state = "TX";
    } else if ($i === "utah") {
        $state = "UT";
    } else if ($i === "vermont") {
        $state = "VT";
    } else if ($i === "virginia") {
        $state = "VA";
    } else if ($i === "washington") {
        $state = "WA";
    } else if ($i === "west virginia") {
        $state = "WV";
    } else if ($i === "wisconsin") {
        $state = "WI";
    } else if ($i === "wyoming") {
        $state = "WY";
    } else if ($i === "american samoa") {
        $state = "AS";
    } else if ($i === "guam") {
        $state = "GU";
    } else if ($i === "northern mariana islands") {
        $state = "MP";
    } else if ($i === "puerto rico") {
        $state = "PR";
    } else if ($i === "virgin islands") {
        $state = "VI";
    } else if ($i === "federated states of micronesia") {
        $state = "FM";
    } else if ($i === "marshall islands") {
        $state = "MH";
    } else if ($i === "palau") {
        $state = "PW";
    } else {
        $state = $i;
    }
    return $state;
}

function export($id)
{
    $con = mysqli_connect("localhost", "amazon", "jsrPR7tZ", "amazon");
    $dbquery = mysqli_query($con, "SELECT * FROM reports WHERE AmazonOrderID = '$id'");

    while ($row = mysqli_fetch_array($dbquery)) {


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

        $checkitems = mysqli_query($con, "SELECT * FROM reports INNER JOIN items ON reports.AmazonOrderID = items.reportID WHERE reports.AmazonOrderID = '$id' ORDER BY items.ItemID ASC");
        $getitems = mysqli_query($con, "SELECT * FROM reports INNER JOIN items ON reports.AmazonOrderID = items.reportID WHERE reports.AmazonOrderID = '$id' ORDER BY items.ItemID ASC");
        if ($check = mysqli_fetch_array($checkitems)) {
            while ($trow = mysqli_fetch_array($getitems)) {
                $item .= '
							<ItemID>' . $trow['ItemID'] . '</ItemID>
							<MfgCode>' . $trow['MfgCode'] . '</MfgCode>
							<PartNum>' . $trow['PartNum'] . '</PartNum>
							<Qty>' . $trow['Qty'] . '</Qty>
							<QtyOrder>' . $trow['QtyOrder'] . '</QtyOrder>
							<SellPrice>' . $trow['SellPrice'] . '</SellPrice>';
            }
        } else {
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


        $file = 'PO-' . $row['TrackNum'] . '.xml';


        //touch('files/xml'.$file);
        /* and finally, put the contents */
        file_put_contents('files/xml/' . $file, $xmlfile);


        $ftp_server = '173.9.236.179';
        $ftp_user_name = 'martin';
        $ftp_user_pass = 'temp12345';

        $fp = fopen('files/xml/' . $file, 'r');


// set up basic connection
        $conn_id = ftp_connect($ftp_server);

// login with username and password
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

        $filepath = '/sbc/amazon/inbound/' . $file;

// try to upload $file
        if (ftp_fput($conn_id, $filepath, $fp, FTP_BINARY)) {

            $query = mysqli_query($con, "UPDATE reports SET exported = '1' WHERE AmazonOrderID = '$id'");
            $filestatus = "Successfully uploaded $file\n";
        } else {
            $filestatus = "There was a problem while uploading $file\n";
        }

// close the connection and the file handler
        ftp_close($conn_id);
        fclose($fp);

        $ftp_server = '173.9.236.179';
        $ftp_user_name = 'martin';
        $ftp_user_pass = 'temp12345';

        $fp = fopen('files/xml/' . $file, 'r');


// set up basic connection
        $conn_id = ftp_connect($ftp_server);

// login with username and password
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
        $filepath_sec = '/sbc/amazon/inbound/archive/' . $file;

        if (ftp_fput($conn_id, $filepath_sec, $fp, FTP_BINARY)) {

            $filestatus2 = "Successfully uploaded $file\n";
            return $filestatus2;
        } else {
            $filestatus2 = "There was a problem while uploading $file\n";
            return $filestatus2;
        }

// close the connection and the file handler
        ftp_close($conn_id);
        fclose($fp);


    }
}

function getTracking($stat)
{
    $ftp_server = '173.9.236.179';
    $ftp_user_name = 'martin';
    $ftp_user_pass = 'temp12345';


// set up basic connection

    $remote_file = '/sbc/invfeed/ATRACK.CSV';
    $local_file = 'files/tracking/ATRACK.CSV';

// open some file to write to
    $handle = fopen($local_file, 'w');

// set up basic connection
    $conn_id = ftp_connect($ftp_server);

// login with username and password
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// try to download $remote_file and save it to $handle
    if (ftp_fget($conn_id, $handle, $remote_file, FTP_ASCII, 0)) {
        $filestatus = "successfully written to $local_file <br />";
    } else {
        $filestatus = "There was a problem while downloading $remote_file to $local_file <br />";
    }


// close the connection and the file handler
    ftp_close($conn_id);
    fclose($handle);


    $addtobase = addtobase("go");
    return $filestatus;
}


function update_tracking($on)
{
    if (isset($on)) {
        $con = mysqli_connect("localhost", "amazon", "jsrPR7tZ", "amazon");
        $dbquery = mysqli_query($con, "UPDATE tracking, atrack SET tracking.tracking_number = atrack.tracking WHERE tracking.order_id = atrack.order_id");
        $status = "Tracking updated in database";
    }
    return $status;
}

function addtobase($action)
{
    $con = mysqli_connect("localhost", "amazon", "jsrPR7tZ", "amazon");
    $local_file = 'files/tracking/ATRACK.CSV';
    $csv = array_map('str_getcsv', file($local_file));

    foreach ($csv as $key => $value) {

        $order_id = $value[0];
        $tracking = str_replace("TRACKING #:", "", $value[1]);
        $status = $value[2];


        $check = mysqli_query($con, "SELECT order_id FROM atrack WHERE order_id = '$order_id'");
        if (!($row = mysqli_fetch_array($check))) {
            $dbquery = mysqli_query($con, "INSERT INTO atrack (order_id, tracking, status) VALUES ('$order_id','$tracking','$status')");
        }
    }
    return "done";
}


function export_tracking($stats)
{
    if (isset($stats)) {
        $con = mysqli_connect("localhost", "amazon", "jsrPR7tZ", "amazon");
        $dbquery = mysqli_query($con, "SELECT * FROM tracking WHERE tracking_number != '' AND exported = '0'");

        $quote = "order-id\torder-item-id\tquantity\tship-date\tcarrier-code\tcarrier-name\ttracking-number\tship-method\n";

        while ($row = mysqli_fetch_array($dbquery)) {
            $datetime = new DateTime($row['ship_date']);
            $date = $datetime->format('Y-m-d');
            $tracking = trim($row['tracking_number'], " ");
            $quote .= $row['order_id'] . "\t" . $row['order_item_id'] . "\t" . $row['quantity'] . "\t" . $date . "\t" . $row['carrier_code'] . "\t\t" . $tracking . "\t" . $row['ship-method'] . "\n";
            $tracking_number = $row['tracking_number'];
            $updatequery = mysqli_query($con, "UPDATE tracking SET exported = '1' WHERE tracking_number = '$tracking_number'");
        }


        $now = rand();
        $file = "files/tracking/Flat.File.ShippingConfirm._TTH_" . $now . ".txt";
        $filename = "Flat.File.ShippingConfirm._TTH_" . $now . ".txt";
        file_put_contents($file, $quote);


        $ftp_server = '173.9.236.179';
        $ftp_user_name = 'martin';
        $ftp_user_pass = 'temp12345';


        $fp = fopen($file, 'r');


// set up basic connection
        $conn_id = ftp_connect($ftp_server);

// login with username and password
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

        $filepath = '/sbc/production/outgoing/' . $filename;

// try to upload $file
        if (ftp_fput($conn_id, $filepath, $fp, FTP_ASCII)) {
            $filestatus = "Successfully uploaded $fp\n";
        } else {
            $filestatus = "There was a problem while uploading $fp\n";
        }

// close the connection and the file handler
        ftp_close($conn_id);
        fclose($fp);
    }
    return $filestatus;
}

?>