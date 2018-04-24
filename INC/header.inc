<?php
//header.inc is the collection of all common parameters and functions.
// Define variables
$systemport = "61254";
$systemfolder = "ShowDC";
//$systempath = "http://" . $_SERVER['SERVER_ADDR'] . "/" . $systemfolder . "/";
$systempath = "http://10.10.134.129/ShowDC/";
$txtconip = "localhost";
$txtcon1 = "showdc_act";
$txtcon2 = "1234";
$txtcondb = "showdc";
$remoteaddr = $_SERVER['REMOTE_ADDR'];
$numberinaday = 86400;
date_default_timezone_set("Asia/Bangkok");

$includepath = $_SERVER['DOCUMENT_ROOT'] . "/" . $systemfolder . "/INC/";
ini_set('include_path', $includepath);

$dbconn=mysqli_connect($txtconip,$txtcon1,$txtcon2,$txtcondb);
if (mysqli_connect_errno($dbconn))
{	
	echo "Database System error!!!"; //"Failed to connect to MySQL: " . mysqli_connect_error();
	exit();
}
mysqli_set_charset($dbconn, "utf8");

//Common Functions
//Function used for run INSERT UPDATE DELETE sql operation into multiple database (parallel database)
function runsql($sql)
{
	global $dbconn;
	return mysqli_query($dbconn,$sql);
}

function runquery($sql)
{
	global $dbconn;
	return mysqli_query($dbconn,$sql);
}

function readquery($result)
{
	return mysqli_fetch_assoc($result);
}

function fixsqlquote($text)
{
	global $dbconn;
	return mysqli_real_escape_string($dbconn,$text);
}

//Function automatic save log
function savelog($logevent,$logtype = 0)
{
	global $user_id;
	$sql = "INSERT INTO log (event,user_id,logtype) VALUES (" .  $logtype . ",'" . $user_id . "','" . $logevent . "')";
	runsql($sql);
}

//Function retrieve user detail on specific user account
function getuserdetail($user_id,$fieldname)
{
	$sql="SELECT " . $fieldname . " FROM useraccount WHERE user_id='" . $user_id . "'";
	$result = runquery($sql);
	$data = readquery($result);
	return $data[$fieldname];
}

//Month in Thai
$month_th = array();
$month_th[1] = "มกราคม";
$month_th[2] = "กุมภาพันธ์";
$month_th[3] = "มีนาคม";
$month_th[4] = "เมษายน";
$month_th[5] = "พฤษภาคม";
$month_th[6] = "มิถุนายน";
$month_th[7] = "กรกฎาคม";
$month_th[8] = "สิงหาคม";
$month_th[9] = "กันยายน";
$month_th[10] = "ตุลาคม";
$month_th[11] = "พฤศจิกายน";
$month_th[12] = "ธันวาคม";

$datetoday = date("Y-m-d");

if(isset($_POST["referer"])) { $referer = $_POST["referer"]; } else { $referer = $_SERVER['HTTP_REFERER']; }
?>