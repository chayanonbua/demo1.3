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
                	<form class="text-center" action="resultSearch.php">
                    	<label>ค้นหาจาก</label>
                        <select style="width:12%;text-align:center">
                            <option value="all"> ทั้งหมด</option>
                            <option value="word">คำ</option>
                            <option value="category">หมวดหมู่</option>
                            <option value="wordCategory">ประเภทของคำ</option>                            
                        </select>                
                        <input type="text" id="input" style="width:40%">
                        <button type="submit" class="btn btn-default" >ค้นหา</button>
                     </form>             	            		
                </div>
            </div> <!-- End Search bar-->
            
            <div class="row" > <!-- category content -->
            	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" > <!-- category -->
                <label>หมวดมู่</label>
               		<table class="table"> 
                            <tr> <td> สัตว์ </td>  </tr>
                            <tr> <td> ของใช้ </td> </tr>
                            <tr> <td> ตัวเลข </td> </tr>
                            <tr> <td> ยานพาหนะ </td> </tr>
                            <tr> <td> อาหารและเครื่องดื่ม </td> </tr>
                            <tr> <td> ท่าทาง </td> </tr>
                            <tr> <td> อารมณ์ </td> </tr>  
                            <tr> <td> สถานที่ </td> </tr>                         
					</table>
                </div>	<!-- End category -->
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" > <!-- word -->
               	<label>ตัวอักษร</label>	
                    <table class="table"> 
                            <tr> <td> ก </td>   <td> ข </td> </tr>
                            <tr> <td> ค </td>   <td> ง </td> </tr>
                            <tr> <td> จ </td>   <td> ฉ </td> </tr>
                            <tr> <td> ช </td>   <td> ซ </td> </tr>
                            <tr> <td> ฌ </td>   <td> ณ </td> </tr>                                                     
					</table>
                </div>	<!-- End word -->
                
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" > <!-- wordcategory -->
               	<label>ประเภทของคำ</label>	
                    <table class="table"> 
                            <tr> <td> คำนาม </td>  </tr>
                            <tr> <td> คำกริยา </td>  </tr>
                            <tr> <td> คำสรรพนาม </td>  </tr>
                            <tr> <td> คำขยาย </td>  </tr>
                            <tr> <td> คำบอกเวลา </td>  </tr>                                                     
					</table>
                </div>	<!-- End wordcategory -->
            </div> <!-- End category content-->
            
            <div class="row" > <!-- row footer -->
            	<div class="col-lg-12 col-md-12" style="background-color:#09F">
            		<p > </p>
                </div>
            </div> <!-- End row footer-->
            
        </div>  <!-- End container -->
        
         
    </body>
</html>
