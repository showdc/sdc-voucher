<?php include 'INC/header.inc';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'INC/metatag.inc';?>
<title>ผู้จำหน่าย Voucher</title>
</head>

<body>
<?php include 'INC/menubar.inc';?>
<?php
$colmx = 3;
$col = 1;
?>
<center><font size="+2"><b>จัดการข้อมูลผู้จำหน่าย Voucher</b></font>
<form name="agent" method="post" action="agent_detail.php">
<table width="80%">
<tr bgcolor="#33CCFF"><td colspan="<?php echo $colmx; ?>" align="center">รายชื่อผู้จำหน่าย Voucher</td></tr>
<?php
$sql = "SELECT * FROM agent ORDER BY agent_name";
$result = runquery($sql);
while($data = readquery($result))
{
	if($col == 1) { echo "<tr>"; }
	echo "<td><input type='radio' name='aid' value='" . $data["agent_id"] . "'>" . $data["agent_name"] . "</font></td>";
	$col++;
	if($col > $colmx) { echo "</tr>"; $col = 1; }
}
if($col != 1) { echo "</tr>"; }
?>
<tr bgcolor="#FFFFCC"><td colspan="<?php echo $colmx; ?>"><input type='radio' name='tid' value='' />[+] เพิ่มชื่อผู้จำหน่าย Voucher</td></tr>
</table>
<input type="submit" value="เลือก"/>
</form>
</center>
</body>
</html>