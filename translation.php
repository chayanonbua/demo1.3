<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>

        <meta charset="tis-620">
        <title>DEMO 1.3</title>

        <!-- Jquery -->
        <script type="text/javascript" src="style/js/jquery-1.11.3.js"></script>
        <!-- End Jquery -->

        <!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="style/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="style/css/bootstrap-theme.css" />
        <script type="text/javascript" src="style/js/bootstrap.js"></script>
        <!-- End Bootstrap -->

    </head>
    <body>
    <?
		$videoNum=0;$videoCount=0; $test ="";

		$link = mysql_connect("localhost","root","root1234");
		$objDB = mysql_select_db("thaisignlanguage2");
	//	mysql_query("SET NAMES TIS620");
		// ����觷�������ӹ����������Ѻ��ä����
	?>

        <div class="container" style="background-color:#09F" >
            <div class="row"> <!-- row banner -->
                <div class="col-lg-12 col-md-12">
                    <img src="pic/testBanner.jpg" class="img-responsive" >
                </div>
            </div>	<!-- End row banner-->

            <div class="row" style="background-color: #FFF; margin: 0px;"> <!-- row menu -->
   			 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px;" >
        		<nav style="width:100%; margin-bottom:0px;" class="navbar navbar-default">
                	<div class="container-fluid"><div class="navbar-header">  <a href="index.php" class="navbar-brand"> HOME</a></div> <!-- HOME Main-->
                    	<div class="collapse navbar-collapse" ><ul class="nav navbar-nav">
							<li><a href="vocabulary.php"><i class='fa fa-list'></i>คำศัพท์</a></li>
							<li><a href="translation.php"><i class='fa fa-cubes'></i>แปลประโยค</a></li>
                            <li><a href="reference.php"><i class='fa fa-cubes'></i>อ้างอิง</a></li>
                            <li><a href="other.php"><i class='fa fa-cubes'></i>เว็บภาษามืออื่นๆ</a></li>
						</ul></div>
                     </div>
                 </nav>
              </div>	<!-- End row menu-->

          	<div class="row" > <!-- row header content -->
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                </div>
            </div> <!-- End row header content-->


            <div class="row" style="margin-top:50px"> <!-- row content -->
            	<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 text-center" > <!-- input -->
                  		<form name="form1" style="margin-left:10px" class="text-center" method="post"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
                      <label id="label1" >ข้อความ  </label>
                      <input type="text" name="input" style="text-align:center"  value="<?php echo $input ?>">
                      <label id="tranBack" for="tranback" style="margin-top:50px">ภาษาไทย = </label>
                      <?php
					  		$id[20];$wordCount=0;
							include 'testSWATH.php';
							if(isset($_POST['submit']))
							 $input = $_POST['input'];
							 if($input!=""){
								$sen = start($input);
								echo $sen;

								 $senNOP = preg_split("/[+]/", $sen, 0, PREG_SPLIT_NO_EMPTY); // �¡����੾�Ф������������ͧ���� +

								for($i=0;$i<count($senNOP);$i++)
								{
									$senNOP[$i] = preg_replace('/\s+/', '', $senNOP[$i]);

                  $strSQL = "SELECT  * from vocabulary where words = '".$senNOP[$i]."'";
              		$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
              		// �Ѻ�ӹǹ��������
              		$result=mysql_query("SELECT  count(*) as total from vocabulary where words = '".$senNOP[$i]."'");
              		$data=mysql_fetch_assoc($result);

              		if($data['total']==0) //ถ้าหาใน word ไม่เจอให้ไปหาใน synonyms
              		{
              			$strSQL = "SELECT * from vocabulary where synonyms LIKE '%".$senNOP[$i]."%'";
              			$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
              		}


									//$strSQL = "SELECT  * from vocabulary where words LIKE '%".$senNOP[$i]."%'";
									//$objQuery = mysql_query($strSQL) or die ("Error Query [".$strSQL."]");
									while($objResult = mysql_fetch_array($objQuery))
									{
											$id[$i]=$objResult["id"];
									}
								}
								$wordCount=count($senNOP);
								//echo $senNOP[0];
							 }
					?>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-center"> <!-- button -->
            		<button  name="submit" type="submit" class="btn btn-default" >แปลประโยค</button>
                </div>
                <div  class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-center">

                </div>

                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 text-center embed-responsive-16by9"> <!-- video -->
            	  <video width="600" controls id="myVideo">
                 <source src="vdo//<?php echo $id[0].".mp4";?>" type="video/mp4">
                  </video>

            <script type='text/javascript'>

				 var videoSource = <? echo json_encode($id); ?>;
				 var videoCount = videoSource.length;
				alert(videoCount);

				var i=1;


				function videoPlay(videoNum)
                {
					document.getElementById("myVideo").setAttribute("src",'vdo//'+videoSource[videoNum]+'.mp4');
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
							document.getElementById("myVideo").setAttribute("src",'vdo//'+videoSource[0]+'.mp4');
							i=1;
							}
							else{
							videoPlay(i-1);
							}

       			}
		</script>

                    </form>

                </div>

            </div> <!-- End row content-->

            <div class="row" > <!-- row footer -->
            	<div class="col-lg-12 col-md-12" style="background-color:#09F">
            		<p > </p>
                </div>
            </div> <!-- End row footer-->
        </div>  <!-- End container -->
    </body>
</html>
