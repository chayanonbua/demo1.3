<?php

define('SWATH', 'C:\\AppServ\\www\\Thesis\\demo1.1');
?>
<html>
<head>
<meta charset="TIS-620" />
</head>
<body>
	
     <?php
	 	$word;	$role; $sentenceRole;$ALLSentenceRole;
		$countS = 0;$countV = 0;
	 	if(isset($_POST['submit'])) 
	 	$input = $_POST['input'];
		$ans=swath($input);
		$count = 1;
		
		
		
		//echo array_search('V',$sentenceRole);
		function start($input){				
					$ans=swath($input);
					$count = 1;
					
					foreach($ans as $value){
						$swathWord = preg_split("/[@]/", $value, 0, PREG_SPLIT_NO_EMPTY);
						$word[$count] = $swathWord[0];
						$role[$count] = $swathWord[1];
						$sentenceRole[$count] = GetSentenceRole($role[$count]);
						//echo "คำที่ ".$count ." ". $word[$count]. " หน้าที่ ".$role[$count]. " หน้าที่ในประโยค ".$sentenceRole[$count]."<br>";  
						$ALLSentenceRole = $ALLSentenceRole . $sentenceRole[$count];
						$count=$count+1;
					}	
					
					return GetTSSentence($ALLSentenceRole,$word);
	}
	function swath($input_text)
		{
		//สร้าง tem file
		$input_filename= tempnam("/tmp", "swath_");
		$output_filename= tempnam("/tmp", "swath_");	
		//$input_text = iconv('UTF-8', 'TIS-620', trim($input_text));
		//เอาตัวหนังสือที่รับเข้ามาใส่ไปใส่ไฟล์ input
		file_put_contents($input_filename, $input_text);
		//สั่งรัน SWATH และเอาผลที่ได้ใส่ไปยัง outputfile
		exec(SWATH .'/swath.exe -m bip < ' . $input_filename . ' > ' . $output_filename);
		//เอาตัวหนังสือจาก input file ใส่ไว้ยังตัวแปร raw
		$raw = file_get_contents($output_filename);
		$raw = iconv('TIS-620', 'TIS-620', rtrim($raw));
		
		//$raw = preg_replace('/| |/', '|', $raw);
	
		//unlink($input_filename);
		//unlink($output_filename);
		
		// ส่งค่าได้กลับโดยแยกจากตัว |
		return preg_split("/[|]/", $raw, -1, PREG_SPLIT_NO_EMPTY);
	}	
	
	function GetSentenceRole($input){
		if($input=="PPRS" || $input=="NCMN" ){
			if($GLOBALS['countS']==0){
				$GLOBALS['countS']=1;
				return "S";
			}
			else if($GLOBALS['countS']==1){
				 return "O";
			}
		}
		else if($input=="VACT" || $input=="VSTA" || $input=="VATT"){
			$GLOBALS['countV']=$GLOBALS['countV']+1;
			return "V";		
		}	
		else if($input=="NEG"){	
			return "NEG";
		}
		else{
			return("x");
		}
	}
	
	function GetTSSentence($ALLSentenceRole,$word){
		if($ALLSentenceRole=="SV" || $ALLSentenceRole=="SVV"){
			return $word[1]." + ".$word[2];
		}	
		else if ($ALLSentenceRole=="SNEGV"){
			return $word[1]." +".$word[3]." + ".$word[2];  // S + NEG + V 
		}
		else if ($ALLSentenceRole=="SVO"){
			return $word[3]." +"." CL+ ".$word[1]." + ".$word[2];  // O+CL+S+V
		}
		else if ($ALLSentenceRole=="SNEGVO"){
			return $word[4]." +"." CL+ ".$word[1]." + ".$word[3] ." + " . $word[2];  // O+CL+S+V+NEG
		}
		else{
			return "ไม่สามารถแปลเป็นภาษามือได้ เนื่องจากประโยคไม่ตรงกับเงื่อนไขที่กำหนด";
		}
	}
	
?>

     
</body>
</html>