<?php include 'INC/header.inc';?>
<?php
$operation = $_POST["op"];
$tenant_id = $_POST["tid"];

if($tenant_id != "")
{
	switch($operation)
	{
		case 0:
			$sql = "DELETE FROM voucher_used WHERE tenant_id=" . $tenant_id . " AND status=0";
			runsql($sql);
			break;
		case 1:
			$sql = "SELECT * FROM voucher_used WHERE tenant_id=" . $tenant_id . " AND status=0";
			$result = runquery($sql);
			while($data = readquery($result))
			{
				$voucher_id = $data["voucher_id"];
				if(is_null($data["tenant_id"])) { $tenant_id = "Null"; } else { $tenant_id = $data["tenant_id"]; }
				$amount_paid = $data["amount_paid"];
				if(is_null($data["date_used"])) { $date_used = "Null"; } else { $date_used = "'" . date("Y-m-d",strtotime($data["date_used"])) . "'"; }
				$sql = "UPDATE voucher SET status=2,date_used=" . $date_used . ",tenant_id=" . $tenant_id;
				if(!is_null($data["amount_paid"])) { $sql .= ",amount_paid=" . $amount_paid; }
				$sql .=" WHERE voucher_id='" . $voucher_id . "'";
				runsql($sql);
			}
			$sql = "UPDATE voucher_used SET status=1 WHERE tenant_id=" . $tenant_id . " AND status=0";
			runsql($sql);
			break;
		default:
	}
}

header("Location: " . $referer); 
exit();
?>
