<?php include 'INC/header.inc';?>
<?php
$tenant_name = "";
$company_name = "";
$floor = "";
$room = "";
$new = true;

if(isset($_POST["tid"]) and $_POST["tid"] != "")
{
	$tenant_id = $_POST["tid"];
	$sql = "SELECT * FROM tenant WHERE tenant_id=" . $tenant_id;
	$result = runquery($sql);
	if($data = readquery($result))
	{
		$tenant_name = $data["tenant_name"];
		$company_name = $data["company_name"];
		$floor = $data["floor"];
		$room = $data["room"];
		$new = false;
	}
	else
	{
		$tenant_id = "";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'metatag.inc';?>
<title>ผู้เช่าพื้นที่</title>
</head>

<body>
<?php include 'menubar.inc';?>
<a href="<?php echo $referer; ?>">ย้อนกลับ</a>
<center><font size="+2"><b>จัดการข้อมูลผู้เช่าพื้นที่</b></font></center>
<form name="tenant" method="post" action="tenant_exec.php">
<input type="hidden" name="referer" value="<?php echo $referer; ?>" />
<input type="hidden" name="tid" value="<?php echo $tenant_id; ?>" />
<table>
<tr bgcolor="#33CCFF"><td colspan="2">แก้ไขข้อมูลผู้เช่าพื้นที่</td></tr>
<tr><td>Tenant Name</td><td><input type="text" name="tname" value="<?php echo $tenant_name ?>" maxlength="50" style="width:200px"/></td></tr>
<tr><td>Company Name</td><td><input type="text" name="cname" value="<?php echo $company_name ?>" maxlength="50" style="width:200px"/></td></tr>
<tr><td>Floor</td><td><input type="text" name="flr" value="<?php echo $floor ?>" maxlength="10" style="width:200px"/></td></tr>
<tr><td>Room</td><td><input type="text" name="rm" value="<?php echo $room ?>" maxlength="10" style="width:200px"/></td></tr>
<tr><td><input type="radio" name="op" value="1" checked="checked"/>บันทึกข้อมูล</td>
<td><?php if(!$new) {?><input type="radio" name="op" value="0" />ลบข้อมูล</td><?php } ?></td></tr>
<tr><td><input type="reset" value="คืนค่าเดิม"/></td><td align="right"><input type="submit" value="ดำเนินการ"/></td></tr>
</table>

</form>
</body>
</html>