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
	$sql = "SELECT  * from vocabulary;"; // ����觷������ӹ������
	$result = mysql_query($sql);
	$num_record = mysql_num_rows	($result); // �Ѻ�ӹǹ�ä����
	echo "<table border=1  cellpadding=2 cellspacing=0>";
	echo "<tr><td>�ӴѺ </td><td>���Ѿ��</td><td>�����˵�</td></tr>";
	
	while ($dbarr =mysql_fetch_row($result)) //�кؤ��ŧ Array
	{
	//echo "�ӴѺ���: ".$dbarr[0]." ���Ѿ��: ".$dbarr[1]." �����˵�: ".$dbarr[2]."<p>";
	echo "<tr><td>".$dbarr[0]."</td><td>".$dbarr[1]."</td><td>".$dbarr[2]."</td></tr>";
	
	
	}
	echo "</table>";
	
	
	print_r(mysql_fetch_array($result));
	
	mysql_Close($link); // �Դ����������Ͱӹ������
?>

</body>
</html>