<?php include 'INC/header.inc';?>
<?php
$vclist = $_POST["vclist"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'metatag.inc';?>
<title>บันทึก Voucher ใหม่เข้าสู่ระบบ</title>
</head>

<body>
<?php include 'menubar.inc';?>
<center><font size="+2"><b>บันทึก Voucher ใหม่เข้าสู่ระบบ</b></font>
<table width="80%">
<tr><td width="50%" valign="top" align="center" bgcolor="#33CCFF">
	<form name="voucher_add" method="post" action="voucher_add.php">
    <b>นำเข้าข้อมูล Excel</b>
	<table width="90%" cellpadding=0 cellspacing=0 border=0><tr>
    <td>ผู้จำหน่าย Voucher</td>
    <td>
    <SELECT name="aid">
    <OPTION value="">==ระบุผู้จำหน่าย Voucher==</OPTION>
<?php
$sql = "SELECT * FROM agent ORDER BY agent_name";
$result = runquery($sql);
while($data = readquery($result))
{
	echo "<OPTION value='" . $data["agent_id"] . "'>" . $data["agent_name"] . "</OPTION>";
}
?>
	</SELECT></td></tr>
    <tr><td>วันที่ออก</td><td><INPUT type="text" name="dateiss" value="<?php echo date("Y-m-d"); ?>" maxlength=10 style="width:100px"/> (ตัวอย่างรูปแบบวันที่ 2016-12-31)</td></tr>
	<tr><td>วันที่หมดอายุ</td><td><INPUT type="text" name="dateexp" value="" maxlength=10 style="width:100px"/> (ตัวอย่างรูปแบบวันที่ 2016-12-31)</td></tr>
    <tr><td colspan=2 align="center"><TEXTAREA name="vclist" style="width:95%;height:400px"><?php echo $vclist; ?></TEXTAREA></td></tr>
    <tr><td colspan=2 align="center"><input type="submit" value="อ่านข้อมูล"/></td></tr>
    </table>
    </form>
</td>
<td valign="top" align="center">
	<form name="voucher_addexec" method="post" action="voucher_addexec.php">
	
<?php
$sql = "SELECT COUNT(voucher_id) AS total_vc FROM voucher";
$result = runquery($sql);
$data = readquery($result);
echo "จำนวน Voucher ที่มีอยู่ในระบบทั้งหมด จำนวน <font color='#FF0000'>" . number_format($data["total_vc"],0,'.',',') . "</font> ใบ<br>";

$sql = "SELECT COUNT(voucher_id) AS total_vc FROM voucher WHERE status=1";
$result = runquery($sql);
$data = readquery($result);
echo "จำนวน Voucher ที่พร้อมใช้ จำนวน <font color='#009900'>" . number_format($data["total_vc"],0,'.',',') . "</font> ใบ<br>";

$sql = "SELECT COUNT(voucher_id) AS total_vc FROM voucher WHERE status=2";
$result = runquery($sql);
$data = readquery($result);
echo "จำนวน Voucher ที่ผู้เช่าพื้นที่รับชำระมาแล้ว จำนวน <font color='#0000FF'>" . number_format($data["total_vc"],0,'.',',') . "</font> ใบ<br>";

$sql = "SELECT * FROM voucher_add LEFT JOIN agent ON voucher_add.agent_id = agent.agent_id WHERE status=0 ORDER BY voucher_id";
$result = runquery($sql);
if(mysqli_num_rows($result) == 0)
{	echo "<br><center>ไม่มีรายการ Voucher สร้างขึ้นใหม่</center>"; }
else
{
	echo "<br><b>Voucher ใหม่จำนวน <font color='#FF0000'>" . mysqli_num_rows($result) . "</font> ใบ</b><br>";
	echo "<input type='radio' name='op' value=1 checked/>ยืนยันการสร้าง Voucher ใหม่ | <input type='radio' name='op' value=0 />ยกเลิก Voucher เหล่านี้<br><input type='submit' value='ดำเนินการ' />";
	echo "<table width='90%' cellpadding=0 cellspacing=0 border=0>";
	echo "<tr align='center' bgcolor='#FFCCCC'><td>รหัส</td><td>ราคา</td><td>สถานะ</td><td>วันที่ออก</td><td>หมดอายุ</td><td>ผู้จำหน่าย</td></tr>";
	while($data = readquery($result))
	{
		$voucher_id = $data["voucher_id"];
		$amount = $data["amount"];
		$status = "รอบันทึก";
		if(is_null($data["date_issue"])) { $date_issue = ""; } else { $date_issue = date("Y-m-d",strtotime($data["date_issue"])); }
		if(is_null($data["date_expire"])) { $date_expire = ""; } else { $date_expire = date("Y-m-d",strtotime($data["date_expire"])); }
		$agent_name = $data["agent_name"];
		echo "<tr><td>" . $voucher_id . "</td><td>" . $amount . "</td><td>" . $status . "</td><td>" . $date_issue . "</td><td>" . $date_expire . "</td><td>" . $agent_name . "</td></tr>";
	}
	echo "</table>";
	
}
?>
    </form>
</td></tr>
</table>

</center>
</body>
</html>