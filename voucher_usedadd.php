<?php include 'INC/header.inc';?>
<?php
$voucher_id = $_POST["vid"];
if(is_numeric($_POST["amtp"])) { $amount_paid = $_POST["amtp"]; } else { $amount_paid = "Null"; }
if(is_numeric($_POST["tid"])) { $tenant_id = $_POST["tid"]; } else { $tenant_id = "Null"; }
if(isset($_POST["dateuse"]) && $_POST["dateuse"] !="") { $date_used = "'" . date("Y-m-d",strtotime($_POST["dateuse"])) . "'"; } else { $date_used = "Null"; }

function chkvid($voucher_id)
{
	$sql = "SELECT voucher_id FROM voucher WHERE voucher_id='" . $voucher_id . "'";
	$result = runquery($sql);
	if(mysqli_num_rows($result) == 1) { return true; } else { return false; }
}

function vidamt($voucher_id)
{
	$sql = "SELECT amount FROM voucher WHERE voucher_id='" . $voucher_id . "'";
	$result = runquery($sql);
	$data = readquery($result);
	return $data["amount"];
}

if($tenant_id != "Null" && chkvid($voucher_id))
{
	if(!is_numeric($amount_paid)) { $amount_paid = vidamt($voucher_id); }
	$sql = "INSERT INTO voucher_used(voucher_id,tenant_id,amount_paid,status,date_used) VALUES ('" . $voucher_id . "'," . $tenant_id . "," . $amount_paid . ",0," . $date_used . ")";
	runsql($sql);
}
else
{
	if(!is_numeric($tenant_id)) { $tenant_id = ""; }
}
	header("Location: " . $systempath . "voucher_used.php?tid=" . $tenant_id . "&dateuse=" . $_POST["dateuse"]); 
	exit();
?>
