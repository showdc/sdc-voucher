<?php include 'INC/header.inc';?>
<?php
$referer = $_POST["referer"];
$operation = $_POST["op"];
$tenant_id = $_POST["tid"];
$tenant_name = fixsqlquote($_POST["tname"]);
$company_name = fixsqlquote($_POST["cname"]);
$floor = fixsqlquote($_POST["flr"]);
$room = fixsqlquote($_POST["rm"]);

$errmsg = "";

switch($operation)
{
	case 0:	//Delete
		$sql = "SELECT tenant_id FROM voucher WHERE tenant_id=" . $tenant_id . " LIMIT 1";
		$result = runquery($sql);
		if($data = readquery($result))
		{
			//Found Tenant holding VC that can't delete this Tenant
			$errmsg = "ไม่สามารถลบข้อมูลผู้เช่ารายนี้ได้ เนื่องจากเคยมี Voucher อยู่";
		}
		else
		{
			$sql = "DELETE FROM tenant WHERE tenant_id=" . $tenant_id;
			runquery($sql);
		}
		break;
	case 1:	//Add/Update
		$found = false;
		if($tenant_id == "")
		{
			$sql = "SELECT tenant_id FROM tenant WHERE tenant_name='" . $tenant_name . "'";
			$result = runquery($sql);
			if($data = readquery($result)) { $errmsg = "ไม่สามารถดำเนินการได้เพราะชื่อผู้เช่านี้มี (" . $tenant_name . ") ข้อมูลอยู่แล้ว"; }
		}
		else
		{
			//Check for existing tenant
			$sql = "SELECT tenant_id FROM tenant WHERE tenant_id=" . $tenant_id;
			$result = runquery($sql);
			if($data = readquery($result)) { $found = true; }
		}
		if($errmsg == "")
		{
			if($found) { $sql = "UPDATE tenant SET tenant_name='" . $tenant_name . "',company_name='" . $company_name . "',floor='" . $floor . "',room='" . $room . "' WHERE tenant_id=" . $tenant_id; }
			else { $sql = "INSERT INTO tenant(tenant_name,company_name,floor,room) VALUES ('" . $tenant_name . "','" . $company_name . "','" . $floor . "','" . $room . "')"; }
			runsql($sql);
		}
		break;
	default:
		$errmsg = "ไม่สามารถดำเนินการได้เพราะคำสั่งผิดพลาด";
}

if($errmsg == "")
{
	header("Location: " . $referer); 
	exit();
}
else
{?>
<a href="<?php echo $referer; ?>">ย้อนกลับ</a><br>
<?php
	echo $errmsg;
}
?>