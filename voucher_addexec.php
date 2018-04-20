<?php include 'INC/header.inc';?>
<?php
ini_set('max_execution_time', 0);  //Extend Maximul Exec Time

$operation = $_POST["op"];

switch($operation)
{
	case 0:
		$sql = "DELETE FROM voucher_add WHERE status=0";
		runsql($sql);
		break;
	case 1:
		$sql = "SELECT * FROM voucher_add WHERE status=0";
		$result = runquery($sql);
		$sql = "";
		while($data = readquery($result))
		{
			$voucher_id = $data["voucher_id"];
			$amount = $data["amount"];
			$amount_paid = $amount;
			if(is_null($data["date_issue"])) { $date_issue = "Null"; } else { $date_issue = "'" . date("Y-m-d",strtotime($data["date_issue"])) . "'"; }
			if(is_null($data["date_expire"])) { $date_expire = "Null"; } else { $date_expire = "'" . date("Y-m-d",strtotime($data["date_expire"])) . "'"; }
			if(is_null($data["agent_id"])) { $agent_id = "Null"; } else { $agent_id = $data["agent_id"]; }
			if($sql != "") { $sql .= ","; }
			$sql .= "('" . $voucher_id . "'," . $amount . "," . $amount_paid . ",1," . $date_issue . "," . $date_expire . "," . $agent_id . ")";
		}
		$sql = "INSERT INTO voucher(voucher_id,amount,amount_paid,status,date_issue,date_expire,agent_id) VALUES " . $sql;
		runsql($sql);
		
		$sql = "UPDATE voucher_add SET status=1 WHERE status=0";
		runsql($sql);
		break;
	default:
}

header("Location: " . $referer); 
exit();
?>
