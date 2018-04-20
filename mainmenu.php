<?php include 'INC/header.inc';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'INC/metatag.inc';?>
<title>หน้าแรกของระบบ</title>
</head>

<body>
<?php include 'INC/menubar.inc';?>
<center>
<font size="+2"><b>ยินดีต้อนรับสู่ระบบ Voucher</b></font>
<table width="80%">
<tr bgcolor="#FFFFCC"><td><a href="tenant_list.php">1.จัดการข้อมูลผู้เช่าพื้นที่</a></td></tr>
<tr bgcolor="#66FF99"><td><a href="agent_list.php">2.จัดการข้อมูลผู้จำหน่าย Voucher</a></td></tr>
<tr bgcolor="#CCFFFF"><td><a href="voucher_input.php">3.บันทึก Voucher ใหม่เข้าสู่ระบบ</a></td></tr>
<tr bgcolor="#FFCCFF"><td><a href="voucher_used.php">4.บันทึก Voucher รับจากผู้เช่าพื้นที่</a></td></tr>
<tr bgcolor="#FFCC99"><td><a href="tenant_report.php">5.รายงานผู้เช่าพื้นที่</a></td></tr>
</table>
</center>
</body>
</html>