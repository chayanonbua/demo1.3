 <?php
	define('SWATH', 'C:\\AppServ\\www\\Thesis\\demo1.1');
	header('Content-Type: text/html; charset=utf-8');
 	
		
	$word;	$role; $sentenceRole;$ALLSentenceRole;
					$countS = 0;$countV = 0;
					
	function start($input){				
					$ans=swath($input);
					$count = 1;
					
					foreach($ans as $value){
						$swathWord = preg_split("/[@]/", $value, 0, PREG_SPLIT_NO_EMPTY);
						$word[$count] = $swathWord[0];
						$role[$count] = $swathWord[1];
						$sentenceRole[$count] = GetSentenceRole($role[$count]);
						echo "�ӷ�� ".$count ." ". $word[$count]. " ˹�ҷ�� ".$role[$count]. " ˹�ҷ��㹻���¤ ".$sentenceRole[$count]."<br>";  
						$ALLSentenceRole = $ALLSentenceRole . $sentenceRole[$count];
						$count=$count+1;
					}	
	}
		
	function swath($input_text)
		{
		//���ҧ tem file
		$input_filename= tempnam("/tmp", "swath_");
		$output_filename= tempnam("/tmp", "swath_");	
		//$input_text = iconv('UTF-8', 'TIS-620', trim($input_text));
		//��ҵ��˹ѧ��ͷ���Ѻ��������������� input
		file_put_contents($input_filename, $input_text);
		//����ѹ SWATH �����Ҽŷ���������ѧ outputfile
		exec(SWATH .'/swath.exe -m bip < ' . $input_filename . ' > ' . $output_filename);
		//��ҵ��˹ѧ��ͨҡ input file �������ѧ����� raw
		$raw = file_get_contents($output_filename);
		$raw = iconv('TIS-620', 'TIS-620', rtrim($raw));
		
		//$raw = preg_replace('/| |/', '|', $raw);
	
		//unlink($input_filename);
		//unlink($output_filename);
		
		// �觤�����Ѻ���¡�ҡ��� |
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
			return "�������ö������������� ���ͧ�ҡ����¤���ç�Ѻ���͹䢷���˹�";
		}
	}
	
?>
<html>
<head>
<meta charset="TIS-620" />
</head>
<body>
	<font size=50>TEST SWATH</font> <br> <br>
	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" > 	
		<input type="text" name="input" size="50" width="50" style="font-size:40px"/>
        <input type="submit" name="submit"  value="�Ѵ��" size="70" style="height:70px;width:70px"/>
     </form>
    <font size="25">
    </body>
</html>