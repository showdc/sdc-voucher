<?php include 'INC/header.inc';?>
<?php
$referer = $_POST["referer"];
$operation = $_POST["op"];
$agent_id = $_POST["aid"];
$agent_name = fixsqlquote($_POST["aname"]);

$errmsg = "";

switch($operation)
{
	case 0:	//Delete
		$sql = "SELECT agent_id FROM voucher WHERE agent_id=" . $agent_id . " LIMIT 1";
		$result = runquery($sql);
		if($data = readquery($result))
		{
			//Found Tenant holding VC that can't delete this Tenant
			$errmsg = "ไม่สามารถลบข้อมูลผู้จำหน่ายรายนี้ได้ เนื่องจากเคยมี Voucher อยู่";
		}
		else
		{
			$sql = "DELETE FROM agent WHERE agent_id=" . $agent_id;
			runquery($sql);
		}
		break;
	case 1:	//Add/Update
		$found = false;
		if($agent_id == "")
		{
			$sql = "SELECT agent_id FROM agent WHERE agent_name='" . $agent_name . "'";
			$result = runquery($sql);
			if($data = readquery($result)) { $errmsg = "ไม่สามารถดำเนินการได้เพราะชื่อผู้จำหน่ายนี้มี (" . $agent_name . ") ข้อมูลอยู่แล้ว"; }
		}
		else
		{
			//Check for existing tenant
			$sql = "SELECT agent_id FROM agent WHERE agent_id=" . $agent_id;
			$result = runquery($sql);
			if($data = readquery($result)) { $found = true;}
		}
		if($errmsg == "")
		{
			if($found) { $sql = "UPDATE agent SET agent_name='" . $agent_name . "' WHERE agent_id=" . $agent_id; }
			else { $sql = "INSERT INTO agent(agent_name) VALUES ('" . $agent_name . "')"; }
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