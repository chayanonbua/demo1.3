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
                แบบฟอร์มการเพิ่มข้อมูล<p>
                คำศัพท์ <input type="text" name ="words"> <p>          
                หมายเหตุ <input type="text" name ="note"> <p>     
                <input type ="submit" name="send" value="Submit">
                <input type ="reset" name="cancel" value="Reset">
                </form>
        <?
        }else {
				$link = mysql_connect("localhost","root","root");
				$sql = "use thaisignlanguage";
				$result = mysql_query ($sql);
				mysql_query("SET NAMES TIS620");
				// คำสั่งเพิ่มข้อมูล
				$sql = "INSERT INTO vocabulary (words,note) VALUES ('$words','$note')";
				$result =mysql_query($sql); // ส่ง query ไปเก็บไว้ที่ result
				if($result){
				echo "การเพิ่มข้อมูลลงฐานข้อมูลสำเร็จ<br>";
				mysql_close($link);
        }else{
       			 //echo "ไม่สามารถเพิ่มข้อมูลได้<br>";
				 die('Could not connect: '.mysql_error());// ตรวจสอบควำมผิดพลำด
        		}
      			  echo "<a href=insert.php> กลับหน้าเว็บเพิ่มข้อมูล </a>";
    			 }
?>

</body>
</html>