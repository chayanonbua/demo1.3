<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>Untitled Document</title>
</head>

<body>

<?
	$Eid= $_POST['Eid'];
	$Ename =$Ename;
	$Eage =$Eage;
	$link = mysql_connect("localhost","root","1234");
	$sql = "use testdb";
	$result = mysql_query($sql);
	$sql ="update testtable set name='$Ename',age='$Eage' where id='$Eid' ";
	$result = mysql_query($sql);
	if($result){
		echo "แก้ไขข้อมูลในฐำนข้อมูลประสบควำมสำเร็จ<p>";
		mysql_close($link);
	}else{
		echo "ไม่สามารถแก้ไขข้อมูลในฐานข้อมูลได้<p>";
	}
		echo "<a href=form_search.php> กลับหน้าจอการแก้ไขข้อมูล </a><br>";
?>

</body>
</html>