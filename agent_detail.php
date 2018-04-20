<?php include 'INC/header.inc';?>
<?php
$agent_name = "";
$new = true;

if(isset($_POST["aid"]) and $_POST["aid"] != "")
{
	$agent_id = $_POST["aid"];
	$sql = "SELECT * FROM agent WHERE agent_id=" . $agent_id;
	$result = runquery($sql);
	if($data = readquery($result))
	{
		$agent_name = $data["agent_name"];
		$new = false;
	}
	else
	{
		$agent_id = "";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'INC/metatag.inc';?>
<title>ผู้จำหน่าย Voucher</title>
</head>

<body>
<?php include 'INC/menubar.inc';?>
<a href="<?php echo $referer; ?>">ย้อนกลับ</a>
<center><font size="+2"><b>จัดการข้อมูลผู้จำหน่าย Voucher</b></font></center>
<form name="agent" method="post" action="agent_exec.php">
<input type="hidden" name="referer" value="<?php echo $referer; ?>" />
<input type="hidden" name="aid" value="<?php echo $agent_id; ?>" />
<table>
<tr bgcolor="#33CCFF"><td colspan="2">แก้ไขข้อมูลผู้จำหน่าย Voucher</td></tr>
<tr><td>Agent Name</td><td><input type="text" name="aname" value="<?php echo $agent_name ?>" maxlength="50" style="width:200px"/></td></tr>
<tr><td><input type="radio" name="op" value="1" checked="checked"/>บันทึกข้อมูล</td>
<td><?php if(!$new) {?><input type="radio" name="op" value="0" />ลบข้อมูล</td><?php } ?></td></tr>
<tr><td><input type="reset" value="คืนค่าเดิม"/></td><td align="right"><input type="submit" value="ดำเนินการ"/></td></tr>
</table>

</form>
</body>
</html>