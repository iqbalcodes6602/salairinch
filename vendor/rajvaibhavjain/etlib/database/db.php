<?php

if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST']!="" && $_SERVER['HTTP_HOST']=="localhost"){
	$servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "databasename";
    // $GLOBALS['AppConfig']['folderpath'] = '/atthah/extra/CLSIAS';
    $GLOBALS['AppConfig']['folderpath'] = '/vishal/clsias';
}else{
	$servername = "localhost";
    $username = "username";
    $password = "rajvaibhav";
    $dbname = "databasename";
    $GLOBALS['AppConfig']['folderpath'] = '';
}

$domain = (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost');
$GLOBALS['AppConfig']['NonSecureURL'] = 'http://'.$domain.$GLOBALS['AppConfig']['folderpath'];
$GLOBALS['AppConfig']['SecureURL'] = 'http://'.$domain.$GLOBALS['AppConfig']['folderpath'];
$GLOBALS['AppConfig']['HomeURL'] = (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') ? $GLOBALS['AppConfig']['NonSecureURL'] : $GLOBALS['AppConfig']['SecureURL'];
$GLOBALS['AppConfig']['AdminURL'] = $GLOBALS['AppConfig']['HomeURL'].'/admin';
$GLOBALS['AppConfig']['ImageURL'] = $GLOBALS['AppConfig']['HomeURL'].'/assets/';



$GLOBALS['AppConfig']['PhysicalPath'] = dirname(__FILE__).'/../../vendor/autoload.php';
require_once $GLOBALS['AppConfig']['PhysicalPath'];

/* Indian Time */
date_default_timezone_set('Asia/Kolkata');


/*Mail Credential */
$GLOBALS['AppConfig']['SenderName']="CLSIAS";
$GLOBALS['AppConfig']['SenderEmail']="rajvaibhavjain@gmail.com";
$GLOBALS['AppConfig']['SMTPHost']="smtp.gmail.com";
$GLOBALS['AppConfig']['SMTPPort']="587";
$GLOBALS['AppConfig']['SMTPUsername']="rajvaibhavjain@gmail.com";
$GLOBALS['AppConfig']['SMTPPassword']="password";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset( $conn, 'utf8');
$GLOBALS['AppConfig']['mysqli_conn']=$conn;
?>