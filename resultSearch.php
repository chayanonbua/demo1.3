<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>DEMO 1.1</title>
        
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
        <div class="container" style="background-color:#09F">
            <div class="row"> <!-- row banner -->
                <div class="col-lg-12 col-md-12">
                    <img src="pic/testBanner.jpg" class="img-responsive" >
                </div>           
            </div>	<!-- End row banner-->
            
            <div class="row" style="background-color: #FFF; margin: 0px;"> <!-- row menu -->
   			 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
        		<nav style="width:100%; margin-bottom:0px;" class="navbar navbar-default">
                	<div class="container-fluid"><div class="navbar-header">  <a href="index.php" class="navbar-brand"> HOME</a></div> <!-- HOME Main-->
                    	<div class="collapse navbar-collapse" ><ul class="nav navbar-nav">
							<li><a href="vocabulary.php"><i class='fa fa-list'></i>คำศัพท์</a></li>
							<li><a href="translation.php"><i class='fa fa-cubes'></i>แปลประโยค</a></li>
                            <li><a href="reference.php"><i class='fa fa-cubes'></i>อ้างอิง</a></li>
                            <li><a href="other.php"><i class='fa fa-cubes'></i>เว็บภาษามืออื่น ๆ</a></li>
						</ul></div>
                     </div>
                 </nav>    
              </div>	<!-- End row menu-->
            
          	<div class="row" > <!-- row content -->
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            		<p class="text-center" style="padding-top:10px">คำศัพท์</p>
                </div>
            </div> <!-- End row content-->
            <div class="row" > <!-- Search bar -->
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left:10px">
                	<form class="text-center">
                    	<label>ค้นหาจาก</label>
                        <select style="width:12%;text-align:center">
                            <option value="all"> ทั้งหมด</option>
                            <option value="word">คำ</option>
                            <option value="category">หมวดหมู่</option>
                            <option value="wordCategory">ประเภทของคำ</option>                            
                        </select>                
                        <input type="text" id="input" style="width:40%">
                        <button type="submit" class="btn btn-default">ค้นหา</button>
                     </form>             	            		
                </div>
            </div> <!-- End Search bar-->
            
            <div class="row" > <!-- row content-->
            	<div class="col-lg-3 col-md-3 hidden-sm hidden-xs" style="margin-left:0px"> <!-- sidebar -->
                       <div class="panel" > <!-- category panel -->
                            <div class="panel-heading" style="background-color: #e83523;">
                                <div class="panel-title" style="color: #FFFFFF;"><i class="fa fa-home" /></i> หมวดหมู่</div>  <!-- heading panel -->
                             </div> 
                             <div class="panel-body" style="padding: 0px;background-color:#CCC">
                                  <ul class="navsidebg navside nav nav-list" id="yw7">
                                    <li><a href="">สัตว์</a></li>
                                    <li><a href="">ของใช้</a></li>
                                    <li><a href="">ตัวเลข</a></li>
                                    <li><a href="">ยานพาหนะ</a></li>
                                    <li><a href="">อาหารและเครื่องดื่ม</a></li>      
                                    <li><a href="">ท่าทาง</a></li>  
                                    <li><a href="">อารมณ์</a></li>  
                                    <li><a href="">สถานที่</a></li>                            
                                   </ul>
                            </div> 
                        </div><!-- End category panel -->
                        
                        <div class="panel" style="margin-top:5px" > <!-- word panel -->
                            <div class="panel-heading" style="background-color: #e83523;">
                                <div class="panel-title" style="color: #FFFFFF;"><i class="fa fa-home" /></i> ตัวอักษร</div>  <!-- heading panel -->
                             </div> 
                             <div class="panel-body" style="padding: 0px;background-color:#CCC">
                                  <ul class="navsidebg navside nav nav-list" id="yw7">
                                    <li><a href="">ก-ฏ</a></li>
                                    <li><a href="">ฎ-น</a></li>
                                    <li><a href="">บ-ว</a></li>
                                    <li><a href="">ศ-ฮ</a></li>                          
                                   </ul>
                            </div> 
                        </div> <!-- End word panel -->
                        
                         <div class="panel" style="margin-top:5px" > <!-- word panel -->
                            <div class="panel-heading" style="background-color: #e83523;">
                                <div class="panel-title" style="color: #FFFFFF;"><i class="fa fa-home" /></i> ประเภทของคำ</div>  <!-- heading panel -->
                             </div> 
                             <div class="panel-body" style="padding: 0px;background-color:#CCC">
                                  <ul class="navsidebg navside nav nav-list" id="yw7">
                                    <li><a href="">คำนาม</a></li>
                                    <li><a href="">คำกริยา</a></li>
                                    <li><a href="">คำสรรพนาม</a></li>
                                    <li><a href="">คำขยาย</a></li>
                                    <li><a href="">คำบอกเวลา</a></li>                            
                                   </ul>
                            </div>  
                        </div> <!-- End word panel -->
                    </div>	<!-- End sidebar -->       
                     
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" style="margin-bottom:10px;"> <!-- main  -->
                    	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-4"> <!-- vdo  -->
            				<video class="embed-responsive-item" width="100%" controls loop> <source src="vdo/test.mp4" type="video/mp4"></video>
                        </div> <!-- end vdo-->
                        
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4" class="text-center"> <!-- detail  -->
            				<b>รายละเอียด</b>
                            <table class="table table-striped" >
                            	<tr> <td> ความหาย </td>   <td> สวัสดี </td> </tr>
                            	<tr> <td> ประเภทของคำ </td>   <td> คำกริยา </td> </tr>
                            	<tr> <td> หมวดหมู่ </td>   <td> คำทักทาย </td> </tr>
                            	<tr> <td> คำคล้าย </td>   <td> - </td> </tr>
                            </table>
                        </div> <!-- end detail-->
                	</div> <!-- end main-->
                    
                     
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12" style="margin-bottom:10px"> <!-- main  -->
                    	<div class="col-lg-6 col-md-6 col-sm-8 col-xs-4"> <!-- vdo  -->
            				<video class="embed-responsive-item" width="100%" controls loop> <source src="vdo/test.mp4" type="video/mp4"></video>
                        </div> <!-- end vdo-->
                        
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4" class="text-center"> <!-- detail  -->
            				<b>รายละเอียด</b>
                            <table class="table table-striped" >
                            	<tr> <td> ความหาย </td>   <td> สวัสดี </td> </tr>
                            	<tr> <td> ประเภทของคำ </td>   <td> คำกริยา </td> </tr>
                            	<tr> <td> หมวดหมู่ </td>   <td> คำทักทาย </td> </tr>
                            	<tr> <td> คำคล้าย </td>   <td> - </td> </tr>
                            </table>
                        </div> <!-- end detail-->
                	</div> <!-- end main--> 
                    
            </div> <!-- end row content-->        

            <div class="row" > <!-- row footer -->
            	<div class="col-lg-12 col-md-12" style="background-color:#09F">
            		<p > </p>
                </div>
            </div> <!-- End row footer-->
            
        </div>  <!-- End container -->         
    </body>
</html>
