<?php include 'INC/header.inc';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'INC/metatag.inc';?>
<title>ผู้เช่าพื้นที่</title>
</head>

<body>
<?php include 'INC/menubar.inc';?>
<?php
$colmx = 3;
$col = 1;
?>
<center><font size="+2"><b>จัดการข้อมูลผู้เช่าพื้นที่</b></font>
<form name="tenant" method="post" action="tenant_detail.php">
<table width="80%">
<tr bgcolor="#33CCFF"><td colspan="<?php echo $colmx; ?>" align="center">รายชื่อผู้เช่าพื้นที่</td></tr>
<?php
$sql = "SELECT * FROM tenant ORDER BY tenant_name";
$result = runquery($sql);
while($data = readquery($result))
{
	if($col == 1) { echo "<tr>"; }
	echo "<td><input type='radio' name='tid' value='" . $data["tenant_id"] . "'>" . $data["tenant_name"];
	echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color='grey' size='-1'>" . $data["company_name"] . "</font></td>";
	$col++;
	if($col > $colmx) { echo "</tr>"; $col = 1; }
}
if($col != 1) { echo "</tr>"; }
?>
<tr bgcolor="#FFFFCC"><td colspan="<?php echo $colmx; ?>"><input type='radio' name='tid' value='' />[+] เพิ่มชื่อผู้เช่า</td></tr>
</table>
<input type="submit" value="เลือก"/>
</form>
</center>
</body>
</html>