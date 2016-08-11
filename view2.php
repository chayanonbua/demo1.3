<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620" />
<title>Untitled Document</title>
</head>

<body>

<?
		$text[0]=$_GET['txtbox1'];
		$text[1]=$_GET['txtbox2'];
		$text[2]=$_GET['txtbox3'];
		$id[4]; $words[4];$note[4];$videoNum=0;$videoCount=3;;
		
		$link = mysql_connect("localhost","root","root");
		$objDB = mysql_select_db("thaisignlanguage");
		mysql_query("SET NAMES TIS620");
		// คำสั่งที่ใช้อ่ำนข้อมูลสำหรับกำรค้นหำ
?>
		<?php ///////////////////////////////////////////////////ดึงข้อมูล////////////////////////////////////////////////////////////// ?>
		
			<?php
			
			
			for($i=0;$i<3;$i++)
			{
				$strSQL = "SELECT  * from vocabulary where words LIKE '%".$text[$i]."%'";
		    	$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]"); 
				while($objResult = mysql_fetch_array($objQuery))
				{    	  
						$id[$i]=$objResult["id"];
						$words[$i]=$objResult["words"];
						$note[$i]=$objResult["note"];
				}
	
			}
		
	?>
	<?php ////////////////////////////////////////////////////////แสดงผล/////////////////////////////////////////////////////////	?>	

		 <table width="1800" border="1">
	  <tr>
		<th width="600"> <div align="center">คำที่ 1 </div></th>
		<th width="600"> <div align="center">คำที่ 2 </div></th>
		<th width="600"> <div align="center">คำที่ 3 </div></th>
        <tr>
		<td><div align="center"><?php echo $text[0];?>  </div></td>
		<td><div align="center"> <?php echo $text[1];?>   </div></td>
		<td><div align="center">  <?php echo $text[2];?>  </td>
	  </tr>	
      <tr>
      <?php //////////////////////////////////////////////////////// VDO1 /////////////////////////////////////////////////////////	?>	
	 <td align="center">
		<video width="600" controls loop>
 		 <source src="vdo//<?php echo $id[0].".mp4";?>" type="video/mp4">
 		 Your browser does not support HTML5 video.
		</video>
		
	</td>
		<?php //////////////////////////////////////////////////////// VDO2 /////////////////////////////////////////////////////////	?>	
		<td align="center"><video width="600" controls>
 		 <source src="vdo//<?php echo $id[1].".mp4";?>" type="video/mp4">
  		<source src="4.ogg" type="video/ogg">
 		 Your browser does not support HTML5 video.
		</video>
        </td>
    	</td>
        <?php //////////////////////////////////////////////////////// VDO3 /////////////////////////////////////////////////////////	?>	
		<td align="center"><video width="600" controls>
 		 <source src="vdo//<?php echo $id[2].".mp4";?>" type="video/mp4">
  		<source src="4.ogg" type="video/ogg">
 		 Your browser does not support HTML5 video.
		</video>
        </td>
        </tr>
     
        <th>
        <td align="center">
        <video width="600" controls id="myVideo"> 
         <source src="vdo//<?php echo $id[0].".mp4";?>" type="video/mp4">
          </video>
         <?php echo $_GET['txtbox1'].$_GET['txtbox2'].$_GET['txtbox3']; 
		 			echo " (".$id[0]." ".$id[1]." ".$id[2].")";
		  ?>
          
          </td>
          </th>
        <script type='text/javascript'>
				
				 var videoSource = new Array();
				 videoSource[0]='vdo//<?php echo $id[0].".mp4";?>';
				videoSource[1]='vdo//<?php echo $id[1].".mp4";?>';
				videoSource[2]='vdo//<?php echo $id[2].".mp4";?>';
				var videoCount = videoSource.length;
				var i=1;
				
				
				function videoPlay(videoNum)
                {
					document.getElementById("myVideo").setAttribute("src",videoSource[videoNum]);
					document.getElementById("myVideo").load();
					document.getElementById("myVideo").play();
					
                }
				document.getElementById('myVideo').addEventListener('ended',myHandler,false);
				function myHandler() {
							i++;
							if(i == (videoCount-1))
							{
							videoPlay(1);
							}
							else if(i == videoCount+1)
							{
							videoPlay(i-1);
							document.getElementById("myVideo").setAttribute("src",videoSource[0]);
							i=1;
							}
							else{
							videoPlay(i-1);
							}
        
       			}
		</script>
      
     
		
	 

	</table>

	
    
	<?php
	mysql_close($link);
?>


</body>
</html>