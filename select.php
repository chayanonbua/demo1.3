<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Untitled Document</title>
</head>

<body>
<?
	$link = mysql_connect("localhost","root","root");
	$sql = "use thaisignlanguage";
	$result = mysql_query($sql);
	mysql_query("SET NAMES TIS620");
	$sql = "SELECT  * from vocabulary;"; // คำสั่งที่ใช้อ่ำนข้อมูล
	$result = mysql_query($sql);
	$num_record = mysql_num_rows	($result); // นับจำนวนเรคคอร์ด
	echo "<table border=1  cellpadding=2 cellspacing=0>";
	echo "<tr><td>ลำดับ </td><td>คำศัพท์</td><td>หมายเหตุ</td></tr>";
	
	while ($dbarr =mysql_fetch_row($result)) //ระบุค่ำลง Array
	{
	//echo "ลำดับที่: ".$dbarr[0]." คำศัพท์: ".$dbarr[1]." หมายเหตุ: ".$dbarr[2]."<p>";
	echo "<tr><td>".$dbarr[0]."</td><td>".$dbarr[1]."</td><td>".$dbarr[2]."</td></tr>";
	
	
	}
	echo "</table>";
	
	
	print_r(mysql_fetch_array($result));
	
	mysql_Close($link); // ปิดกำรเชื่อมต่อฐำนข้อมูล
?>

</body>
</html>