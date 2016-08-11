<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620" />
<title>Untitled Document</title>
</head>

<body>

<?
		$txtbox =$txtbox;
		$link = mysql_connect("localhost","root","root");
		$objDB = mysql_select_db("thaisignlanguage");
		mysql_query("SET NAMES TIS620");
		// คำสั่งที่ใช้อ่ำนข้อมูลสำหรับกำรค้นหำ
		$strSQL = "SELECT  * from vocabulary where words LIKE '%".$txtbox."%'";
		$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
?>
		<table width="600" border="1">
	  <tr>
		<th width="91"> <div align="center">ID </div></th>
		<th width="198"> <div align="center">คำ </div></th>
		<th width="198"> <div align="center">หมายเหตุ </div></th>
	  </tr>
	<?php
	while($objResult = mysql_fetch_array($objQuery))
	{

	?>
    	  <tr>
		<td><div align="center"><?php echo $objResult["id"];?></div></td>
		<td><div align="center"><?php echo $objResult["words"];?></div></td>
		<td><?php echo $objResult["note"];?></td>
	  </tr>
	<?php
	$id =  $objResult["id"];
	$word = $objResult["words"];
	
	}
	?>
	</table>
    
    <h1> <?php echo $word;?></h1>
    <?php echo $id.".mp4";?>
	<div id="container"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</div>
	<script type="text/javascript" src="swfobject.js"></script>
	<script type="text/javascript">
		var s1 = new SWFObject("player.swf","mediaplayer","500","500","8");
		s1.addParam('allowscriptaccess','always');
		s1.addParam("allowfullscreen","true");		
	    s1.addVariable("file","vdo/<?php echo $id.".mp4";?>");		
		s1.addVariable('displayheight','240');
		s1.addVariable('autoscroll','true');
		s1.write("container");
		
	</script>
    
	<?php
	mysql_close($link);
?>


</body>
</html>