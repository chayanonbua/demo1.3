<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620" />
<title>Untitled Document</title>
</head>

<body>

		<?
		If($send == null){
		?>
               <form method ="post" action="<? Echo $PHP_SELF ?>" >
                Ẻ������������������<p>
                ���Ѿ�� <input type="text" name ="words"> <p>          
                �����˵� <input type="text" name ="note"> <p>     
                <input type ="submit" name="send" value="Submit">
                <input type ="reset" name="cancel" value="Reset">
                </form>
        <?
        }else {
				$link = mysql_connect("localhost","root","root");
				$sql = "use thaisignlanguage";
				$result = mysql_query ($sql);
				mysql_query("SET NAMES TIS620");
				// ���������������
				$sql = "INSERT INTO vocabulary (words,note) VALUES ('$words','$note')";
				$result =mysql_query($sql); // �� query �������� result
				if($result){
				echo "�������������ŧ�ҹ�����������<br>";
				mysql_close($link);
        }else{
       			 //echo "�������ö������������<br>";
				 die('Could not connect: '.mysql_error());// ��Ǩ�ͺ�����Դ��Ӵ
        		}
      			  echo "<a href=insert.php> ��Ѻ˹��������������� </a>";
    			 }
?>

</body>
</html>