<?php include 'INC/header.inc';?>
<?php
$tenant_id = $_GET["tid"];
if(isset($_GET["dateuse"])) { $dateuse = $_GET["dateuse"]; } else { $dateuse = date("Y-m-d"); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'metatag.inc';?>
<title>บันทึก Voucher รับจากผู้เช่าพื้นที่</title>
<script type="text/JavaScript">
function WindowOnLoad()
{
	document.getElementById('vid').select();
}
</script>
</head>

<body onload="JavaScript:WindowOnLoad();">
<?php include 'menubar.inc';?>
<center><font size="+2"><b>บันทึก Voucher รับจากผู้เช่าพื้นที่</b></font>
<table width="80%">
<tr><td width="50%" valign="top" align="center" bgcolor="#33CCFF">
	<form name="voucher_usedadd" method="post" action="voucher_usedadd.php">
    <b>นำเข้าใบ Voucher ที่รับมา</b>
	<table width="90%" cellpadding=0 cellspacing=0 border=0><tr valign="top">
    <td>ผู้เช่าพื้นที่
    <SELECT name="tid">
    <OPTION value="">==ระบุผู้เช่าพื้นที่==</OPTION>
<?php
$sql = "SELECT * FROM tenant ORDER BY tenant_name";
$result = runquery($sql);
while($data = readquery($result))
{
	echo "<OPTION value='" . $data["tenant_id"] . "'";
	if($data["tenant_id"] == $tenant_id) { echo " selected='selected'"; }
	echo ">" . $data["tenant_name"] . "</OPTION>";
}
?>
	</SELECT></td>
    <td>วันที่ใช้ <INPUT type="text" name="dateuse" value="<?php echo $dateuse; ?>" maxlength=10 style="width:100px"/><br />(ตัวอย่างวันที่ 2016-12-31)</td>
    <td>ราคาจ่าย <INPUT type="text" name="amtp" value="" maxlength="10" style="width:50px">บาท<br />(จ่ายเต็มมูลค่าให้ปล่อยว่าง)</td>
	<td>รหัส Voucher<INPUT type="text" id="vid" name="vid" value="" maxlength=13 style="width:120px"/></td>
    <td align="center"><input type="submit" value="รับใบ Voucher/แสดงรายการ"/></td></tr>
    </table>
    </form>
</td></tr>
<tr><td valign="top" align="center">
<?php
if($tenant_id == "")
{
	$sql = "SELECT *,voucher_used.date_used AS date_used,voucher_used.amount_paid AS amount_paid FROM voucher_used ";
	$sql .= "LEFT JOIN voucher ON voucher_used.voucher_id = voucher.voucher_id ";
	$sql .= "LEFT JOIN tenant ON voucher_used.tenant_id = tenant.tenant_id ";
	$sql .= "WHERE voucher_used.status=0 ORDER BY voucher_used.datetime DESC";
	$result = runquery($sql);
	if(mysqli_num_rows($result) == 0)
	{	echo "<center>ไม่มีรายการ Voucher ที่รับมาใหม่</center>"; }
	else
	{
		echo "<b>Voucher รับมารวมทุกผู้เช่าจำนวน <font color='#FF0000'>" . mysqli_num_rows($result) . "</font> ใบ ที่ยังไม่ได้ยืนยันการใช้</b><br>";
		echo "<table width='90%' cellpadding=0 cellspacing=0 border=0>";
		echo "<tr align='center' bgcolor='#FFCCCC'><td>รหัส</td><td>วันที่ใช้</td><td>ราคาVC</td><td>ราคาจ่าย</td><td>ผู้เช่า</td></tr>";
		$sumamount = 0;
		$sumamount_paid = 0;
		while($data = readquery($result))
		{
			
			$voucher_id = $data["voucher_id"];
			$amount = $data["amount"];
			$amount_paid = $data["amount_paid"];
			if(is_null($data["date_used"])) { $date_used = ""; } else { $date_used = date("Y-m-d",strtotime($data["date_used"])); }
			$tenant_name = $data["tenant_name"];
			echo "<tr align='center'><td>" . $voucher_id . "</td><td>" . $date_used . "</td><td align='right'>" . $amount . " บาท</td><td align='right'>" . $amount_paid . " บาท</td><td>" . $tenant_name . "</td></tr>";
			$sumamount = $sumamount + $amount;
			$sumamount_paid = $sumamount_paid + $amount_paid;
		}
		echo "<tr bgcolor='#66FFFF' align='center'><td colspan=2>ยอดรวม</td><td><b>" . number_format($sumamount,0,'.',',') . " บาท</b><td><b>" . number_format($sumamount_paid,0,'.',',') . " บาท</b></td></tr>";
		echo "</table>";	
	}
}
else
{?>
	<form name="voucher_usedexec" method="post" action="voucher_usedexec.php">
    <input type="hidden" name="tid" value="<?php echo $tenant_id; ?>" />
<?php
	$sql = "SELECT *,voucher_used.date_used AS date_used,voucher_used.amount_paid AS amount_paid FROM voucher_used ";
	$sql .= "LEFT JOIN voucher ON voucher_used.voucher_id = voucher.voucher_id ";
	$sql .= "LEFT JOIN tenant ON voucher_used.tenant_id = tenant.tenant_id ";
	$sql .= "WHERE voucher_used.tenant_id=" . $tenant_id . " AND voucher_used.status=0 ORDER BY voucher_used.datetime DESC";
	$result = runquery($sql);
	if(mysqli_num_rows($result) == 0)
	{	echo "<center>ไม่มีรายการ Voucher ที่รับมาใหม่</center>"; }
	else
	{
		echo "<b>Voucher รับมาจำนวน <font color='#FF0000'>" . mysqli_num_rows($result) . "</font> ใบ</b><br>";
		echo "<input type='radio' name='op' value=1 checked/>ยืนยันการใช้ Voucher | <input type='radio' name='op' value=0 />ยกเลิกการรับ Voucher เหล่านี้<br><input type='submit' value='ดำเนินการ' />";
		echo "<table width='90%' cellpadding=0 cellspacing=0 border=0>";
		echo "<tr align='center' bgcolor='#FFCCCC'><td>รหัส</td><td>วันที่ใช้</td><td>ราคาVC</td><td>ราคาจ่าย</td><td>ผู้เช่า</td></tr>";
		$sumamount = 0;
		$sumamount_paid = 0;
		while($data = readquery($result))
		{
			$voucher_id = $data["voucher_id"];
			$amount = $data["amount"];
			$amount_paid = $data["amount_paid"];
			if(is_null($data["date_used"])) { $date_used = ""; } else { $date_used = date("Y-m-d",strtotime($data["date_used"])); }
			$tenant_name = $data["tenant_name"];
			echo "<tr align='center'><td>" . $voucher_id . "</td><td>" . $date_used . "</td><td align='right'>" . $amount . " บาท</td><td align='right'>" . $amount_paid . " บาท</td><td>" . $tenant_name . "</td></tr>";
			$sumamount = $sumamount + $amount;
			$sumamount_paid = $sumamount_paid + $amount_paid;
		}
		echo "<tr bgcolor='#66FFFF' align='center'><td colspan=2>ยอดรวม</td><td><b>" . number_format($sumamount,0,'.',',') . " บาท</b><td><b>" . number_format($sumamount_paid,0,'.',',') . " บาท</b></td></tr>";
		echo "</table>";	
	}?>
    </form>
<?php
}
?>
</td></tr>
</table>

</center>
</body>
</html>