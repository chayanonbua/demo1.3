<?php
header('Content-Type:text/html;charset=TIS-620');

?>
<html>
<head>
<meta charset="TIS-620" />
</head>
<body>
	<font size=50>TEST SWATH</font> <br> <br>
	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" > 	
		<input type="text" name="input" size="50" width="50" style="font-size:40px"/>
        <input type="submit" name="submit"  value="ตัดคำ" size="70" style="height:70px;width:70px"/>
     </form>
    <font size="25">
    <?php 
	include 'testSWATH.php';
    if(isset($_POST['submit'])) 
	 $input = $_POST['input'];
	 start($input);
	?>

     
</body>
</html>