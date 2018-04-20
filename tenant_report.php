<?php include 'INC/header.inc';?>
<?php
$tenant_id = $_GET["tid"];
if(isset($_GET["datestr"])) { $datestr = $_GET["datestr"]; } else { $datestr = date("Y-m-01"); }
if(isset($_GET["dateend"])) { $dateend = $_GET["dateend"]; } else { $dateend = date("Y-m-d"); }

function showdate($date)
{
	if(is_null($date)) { return ""; } else { return date("Y-m-d",strtotime($date)); }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include 'INC/metatag.inc';?>
<title>รายงาน</title>
</head>

<body>
<?php include 'INC/menubar.inc';?>
<center><font size="+2"><b>รายงาน</b></font>
<table width="80%">
<tr><td width="50%" valign="top" align="center" bgcolor="#33CCFF">
	<form name="tenant_report" method="get" action="tenant_report.php">
    <b>รายงาน Voucher ผู้เช่าพื้นที่</b>
	<table width="90%" cellpadding=0 cellspacing=0 border=0><tr>
    <td>ผู้เช่าพื้นที่</td>
    <td>
    <SELECT name="tid">
    <OPTION value="">==ระบุผู้เช่าพื้นที่==</OPTION>
<?php
$sql = "SELECT * FROM tenant ORDER BY tenant_name";
$result = runquery($sql);
	echo "<OPTION value='*'";
	if($tenant_id == "*") { echo " selected='selected'"; }
	echo ">==แสดงทุกผู้เช่า==</OPTION>";
while($data = readquery($result))
{
	echo "<OPTION value='" . $data["tenant_id"] . "'";
	if($data["tenant_id"] == $tenant_id) { echo " selected='selected'"; }
	echo ">" . $data["tenant_name"] . "</OPTION>";
}
?>
	</SELECT></td>
    <td>ตั้งแต่วันที่ <INPUT type="text" name="datestr" value="<?php echo $datestr; ?>" maxlength=10 style="width:100px"/>
    ถึง วันที่ <INPUT type="text" name="dateend" value="<?php echo $dateend; ?>" maxlength=10 style="width:100px"/> (ตัวอย่างรูปแบบวันที่ 2016-12-31)</td>
    <td colspan=2 align="center"><input type="submit" value="แสดง"/></td></tr>
    </table>
    </form>
</td></tr>
<tr><td valign="top" align="center">

<?php
if($tenant_id != "")
{
	$sql = "SELECT * FROM voucher LEFT JOIN tenant ON voucher.tenant_id = tenant.tenant_id WHERE ";
	if($tenant_id != "*") { $sql .= "voucher.tenant_id=" . $tenant_id . " AND"; }
	$sql .= " date_used >='" . $datestr . "' AND date_used <='" . $dateend . "' ORDER BY voucher_id ASC";
	$result = runquery($sql);
	if(mysqli_num_rows($result) == 0)
	{	echo "<center>ไม่มีรายการ Voucher ที่รับมา</center>"; }
	else
	{
		echo "<b>Voucher รับมาจำนวน <font color='#FF0000'>" . mysqli_num_rows($result) . "</font> ใบ</b><br>";
		echo "<table width='90%' cellpadding=0 cellspacing=0 border=1>";
		echo "<tr align='center' bgcolor='#FFCCCC'><td>รหัส</td><td>ราคาVC</td><td>ราคาจ่าย</td><td>สถานะ</td><td>วันที่ออก</td><td>วันที่หมดอายุ</td><td>วันที่ใช้</td><td>ผู้เช่าพื้นที่</td></tr>";
		$sumamount = 0;
		$sumamount_paid = 0;
		while($data = readquery($result))
		{
			$voucher_id = $data["voucher_id"];
			$amount = $data["amount"];
			$amount_paid = $data["amount_paid"];
			switch($data["status"])
			{
				case 0:	$status = "ยังไม่พร้อม";	break;
				case 1:	$status = "พร้อมใช้";	break;
				case 2:	$status = "ใช้แล้ว";	break;
				case 3:	$status = "ยกเลิก";	break;
				default:	$status = "ไม่ทราบ";
			}
			$date_issue = showdate($data["date_issue"]);
			$date_expire = showdate($data["date_expire"]);
			$date_used = showdate($data["date_used"]);
			$tenant_name = $data["tenant_name"];
			echo "<tr align='center'><td>" . $voucher_id . "</td><td align='right'>" . $amount . "</td><td align='right'>" . $amount_paid . "</td><td>" . $status . "<td>" . $date_issue . "</td><td>" . $date_expire . "</td><td>" . $date_used . "</td><td>" . $tenant_name . "</tr>";
			$sumamount = $sumamount + $amount;
			$sumamount_paid = $sumamount_paid + $amount_paid;
		}
		echo "<tr bgcolor='#66FFFF' align='center'><td>ยอดรวม</td><td><b>" . number_format($sumamount,0,'.',',') . " บาท</b></td><td><b>" . number_format($sumamount_paid,0,'.',',') . " บาท</b></td><td colspan=5>&nbsp;</td></tr>";
		echo "</table>";
		
	}
}
?>
    </form>
</td></tr>
</table>

</center>
</body>
</html>