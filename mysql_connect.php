<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title>No.1</title>
</head>

<body>

<? $link = mysql_connect("localhost","root","root");
if($link)
{
echo "Connected successfully <br>";
echo "Connection number = $link";
mysql_close($link); // »Ô´¡ÓÃàª×èÍÁµèÍ MySQL
}
else
{
die('Could not connect: '.mysql_error());// µÃÇ¨ÊÍº¤ÇÓÁ¼Ô´¾ÅÓ´
}
?>

</body>
</html>