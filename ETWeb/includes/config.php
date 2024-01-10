<?php

//Copyright Atthah

//header("Access-Control-Allow-Origin: https://etechmy.com/");
//header("Access-Control-Allow-Credentials: true");

date_default_timezone_set('Asia/Kolkata');
$current_time = date("Y-m-d H:i:s");

ob_start();
// error_reporting(E_ALL); //E_ALL ^ E_NOTICE ^ E_DEPRECATED
// ini_set('display_errors', 1);

static $mysqli_user;
// $mysqli_user = mysqli_connect('localhost', 'ubuntu', 'stream@123') or print(mysqli_error()."error\n");
$mysqli_user = mysqli_connect('localhost', 'root', '') or print(mysqli_error()."error\n");
mysqli_select_db($mysqli_user,"salairinch") or die(mysqli_error()."\n"); 

/* For A Security Level */
$GLOBALS['AppConfig']['folderpath'] = '/salairinch';
$domain = (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost');
$GLOBALS['AppConfig']['NonSecureURL'] = 'http://'.$domain.$GLOBALS['AppConfig']['folderpath'];
$GLOBALS['AppConfig']['SecureURL'] = 'http://'.$domain.$GLOBALS['AppConfig']['folderpath'];
$GLOBALS['AppConfig']['HomeURL'] = (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') ? $GLOBALS['AppConfig']['NonSecureURL'] : $GLOBALS['AppConfig']['SecureURL'];
$GLOBALS['AppConfig']['AdminURL'] = $GLOBALS['AppConfig']['HomeURL'].'/adminpanel';

$GLOBALS['AppConfig']['PhysicalPath'] = dirname(__FILE__).'/../../vendor/autoload.php';
require_once $GLOBALS['AppConfig']['PhysicalPath'];
$GLOBALS['AppConfig']['mysqli_conn']= $mysqli_user;
$conn=$mysqli_user;
/* For A Security Level End */

/* Debug Mode (true if you want to check php log) */
$GLOBALS['AppConfig']['DebugMode']=false;

// /*Test Mail Credential */
// $GLOBALS['AppConfig']['SenderName']="ETWeb";
// $GLOBALS['AppConfig']['SenderEmail']="test@gmail.com";
// $GLOBALS['AppConfig']['SMTPHost']="smtp.gmail.com";
// $GLOBALS['AppConfig']['SMTPPort']="587";
// $GLOBALS['AppConfig']['SMTPUsername']="test@gmail.com";
// $GLOBALS['AppConfig']['SMTPPassword']="test";

?>
