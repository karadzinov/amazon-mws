<?php

require_once 'header.php';
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

return $filestatus;
// close the connection and the file handler
ftp_close($conn_id);
fclose($handle);


$addtobase = addtobase("go");
require_once 'footer.php';
?>