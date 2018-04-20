<?php include 'INC/header.inc';?>
<?php
ini_set('max_execution_time', 0);  //Extend Maximul Exec Time

$vclist = trim($_POST["vclist"]);
if(is_numeric($_POST["aid"])) { $agent_id = $_POST["aid"]; } else { $agent_id = "Null"; }
if(isset($_POST["dateiss"]) && $_POST["dateiss"] !="") { $date_issue = "'" . date("Y-m-d",strtotime($_POST["dateiss"])) . "'"; } else { $date_issue = "Null"; }
if(isset($_POST["dateexp"]) && $_POST["dateexp"] !="") { $date_expire = "'" . date("Y-m-d",strtotime($_POST["dateexp"])) . "'"; } else { $date_expire = "Null"; }

function chkvcid($vcid) { if(strlen(strval($vcid)) == 13) { return true; } else {return false;} }
function chkamt($amt) { if(is_numeric($amt)) { return true; } else { return false; } }

if($vclist != "")
{
	$vouchers = explode("\n",$vclist);
	foreach($vouchers as $val)
	{
		$voucher = explode("\t",$val);
		$voucher_id = trim($voucher[0]);
		$amount = str_replace(",","",trim($voucher[1]));
		if(chkvcid($voucher_id) && chkamt($amount))
		{
			if($sql != "") { $sql .= ","; }
			$sql .= "('" . $voucher_id . "'," . $amount . ",0," . $date_issue . "," . $date_expire . "," . $agent_id . ")";
		}
	}
	$sql = "INSERT INTO voucher_add(voucher_id,amount,status,date_issue,date_expire,agent_id) VALUES " . $sql;
	runsql($sql);
}
header("Location: " . $referer); 
exit();
?>
