<?php

define('SWATH', 'C:\\AppServ\\www\\Thesis\\demo1.3');
?>
<html>
<head>
<meta charset="UTF-8" />
</head>
<body>

     <?php
	 	$word;	$role; $sentenceRole;$ALLSentenceRole; $subject;$verb; $object; $conjunction; $adjective;$NEG;

		$countS = 1;$countV = 1;$countCON=1;$countO=1;$countNEG=1;
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
						$sentenceRole[$count] = SetSentenceRole($role[$count],$word[$count]);
						//echo "�ӷ�� ".$count ." ". $word[$count]. " ˹�ҷ�� ".$role[$count]. " ˹�ҷ��㹻���¤ ".$sentenceRole[$count]."<br>";
						$ALLSentenceRole = $ALLSentenceRole . $sentenceRole[$count];
						$count=$count+1;
					}

					return GetTSSentence($ALLSentenceRole,$word);
	}
	function swath($input_text)
		{
		//���ҧ tem file
		$input_filename= tempnam("/tmp", "swath_");
		$output_filename= tempnam("/tmp", "swath_");
		$input_text = iconv('UTF-8', 'TIS-620', trim($input_text));
		//��ҵ��˹ѧ��ͷ���Ѻ������������������ input
		file_put_contents($input_filename, $input_text);
		//�����ѹ SWATH �����Ҽŷ�����������ѧ outputfile
		exec(SWATH .'/swath.exe -m bip < ' . $input_filename . ' > ' . $output_filename);
		//��ҵ��˹ѧ��ͨҡ input file �������ѧ������ raw
		$raw = file_get_contents($output_filename);
		$raw = iconv('TIS-620', 'UTF-8', rtrim($raw));

		//$raw = preg_replace('/| |/', '|', $raw);

		//unlink($input_filename);
		//unlink($output_filename);

		// �觤�������Ѻ����¡�ҡ��� |
		return preg_split("/[|]/", $raw, -1, PREG_SPLIT_NO_EMPTY);
	}

	function SetSentenceRole($input,$word){
    global $subject;global $verb;global $object;global $conjunction;global $NEG;
		if($input=="PPRS" || $input=="NCMN" ){
			if($GLOBALS['countS']==1){
        $subject[$GLOBALS['countS']]=$word;
				$GLOBALS['countS']=2;
				return "S";
			}
			else if($GLOBALS['countS']==2){
        $object[$GLOBALS['countO']]=$word;
        return "O";
			}
		}
		else if($input=="VACT" || $input=="VSTA" /*|| $input=="VATT"*/){
      $verb[$GLOBALS['countV']] = $word;
      $GLOBALS['countV']=$GLOBALS['countV']+1;
			return "V";
		}
		else if($input=="NEG"){
      $NEG[$GLOBALS['countNEG']] = $word;
      $GLOBALS['countNEG'] = $GLOBALS['countNEG']+1;
			return "NEG";
		}
    else if($input=="JCRG" || $input=="JCMP" || $input=="JSRB" ){
      $GLOBALS['countS']=1;
      $GLOBALS['countCON']=1;
      return "CON";
    }
    else if($input=="ADVN" || $input=="VATT"  ){
      return "ADJ";
    }
		else{
			return("x");
		}
	}

  function GetSentenceRole($word,$number){
    global $subject;global $verb;global $object;global $conjunction;global $NEG;
      if($word=="S"){
        return $subject[$number];
      }
      else if ($word=="V"){
        return  $verb[$number];
      }
      else if ($word=="O"){
        return  $object[$number]." + CL ";
      }
      else if ($word=="CON"){
        return  $conjunction[$number];
      }
      else if ($word=="NEG"){
        return  $NEG[$number];
      }
  }

	function GetTSSentence($ALLSentenceRole,$word){
    if(strpos($ALLSentenceRole,'CON')){ // มีคำเชื่อมประโยค
        $subSen = explode("CON", $ALLSentenceRole);
        $posCON = strpos($ALLSentenceRole,"CON",1);
        if($ALLSentenceRole=="SCONSVO"){
          return $word[5]." + CL + ".$word[1]." + ".$word[2]." + ".$word[3]." + ".$word[4];
        }
        else if ($ALLSentenceRole=="SCONSNEGVO"){
          return $word[6]." + CL + ".$word[1]." + ".$word[2]." + ".$word[3]." + ".$word[5]." + ".$word[4];
          // S + CON + S + NEG + V + O , 2 S , 1 O
        }
        else if ($ALLSentenceRole=="SVOCONS"){
          return $word[3]."+ CL +".$word[4]." + ".$word[5]." CL+ ".$word[1]." + ".$word[2];
        }
        else if ($ALLSentenceRole=="SNEGVOCONS"){
          //S + NEG + V + O + CON + O , 1 S 1 NEG 2 O,
          return $word[4]."+ CL +".$word[5]." + ".$word[6]." + CL + ".$word[1]." + ".$word[3]." + ".$word[2];
        }
        else if ($ALLSentenceRole=="SNEGVOCONNEGVS"){
          return $word[4]."+ CL +".$word[5]." + ".$word[8]." + CL + ".$word[1]." + ".$word[3]." + ".$word[2];
          // S + NEG + V + O + CON + NEG + O , 1 S , 2 NEG , 2 O
        }
        else if ($ALLSentenceRole=="SVOCONSVO"){
          return $word[3]." + CL + ".$word[1]." + ".$word[2]." + " .$word[4]." + ".$word[7]." + CL + ".$word[5]." + ". $word[6]  ;
        }
        else if ($ALLSentenceRole=="SNEGVOCONSVO"){
          // S + NEG + V + O + CON + S + V + O , 2 FULLSEN , 1 NEG FIRST
          return $word[4]." + CL + ".$word[1]." + ".$word[3]." + " .$word[2]." + " .$word[5]." + ".$word[8]." + CL + ".$word[6]." + ". $word[7]  ;
        }
        else if ($ALLSentenceRole=="SVOCONSNEGVO"){
          // S  + V + O + CON + S + V + NEG + O , 2 FULLSEN , 1 NEG SECOND
          return $word[3]." + CL + ".$word[1]." + ".$word[2]." + " .$word[4]." + " .$word[8]." + CL + ".$word[5]." + ".$word[7]." + " .$word[6];
        }
        else if ($ALLSentenceRole=="SNEGVOCONSNEGVO"){
          // S + NEG + V + O + CON + S + V + NEG + O , 2 NEG
          return $word[4]." + CL + ".$word[1]." + ".$word[3]." + " .$word[2]." + " .$word[5]." + " .$word[9]." + CL + " .$word[6]." + " .$word[8]." + " .$word[7];
        }
        else {
           //return $ALLSentenceRole . " ไม่สามารถแปลประโยคได้ เนื่องจากไม่ต้องกับประโยคไม่ตรงกับข้อกำหนด";
           return $ALLSentenceRole . " = " . $word[1]." + ".$word[2]." + ". $word[3]." + ".$word[4]."+ ".$word[5]."+ ".$word[6]."+ ".$word[7];
         }
    }else {
      if($ALLSentenceRole=="SV" || $ALLSentenceRole=="SVV"){
        return GetSentenceRole("S",1)." + ".GetSentenceRole("V",1);
      }
      else if ($ALLSentenceRole=="SNEGV"){
        return GetSentenceRole("S",1)." + ".GetSentenceRole("NEG",1)." + ".GetSentenceRole("V",1);  // S + NEG + V
      }
      else if ($ALLSentenceRole=="SVO"){
        return GetSentenceRole("O",1)." + ".GetSentenceRole("S",1)." + ".GetSentenceRole("V",1);  // O+CL+S+V
      }
      else if ($ALLSentenceRole=="SNEGVO"){
        return GetSentenceRole("O",1)." + ".GetSentenceRole("S",1)." + ".GetSentenceRole("V",1)." + ".GetSentenceRole("NEG",1);  // O+CL+S+V+NEG
      }
      else{
        //return $word[1]." + ".$word[2];
        //return $ALLSentenceRole . "ไม่สามารถแปลประโยคได้ เนื่องจากไม่ต้องกับประโยคไม่ตรงกับข้อกำหนด";
        return $ALLSentenceRole . " = " . $word[1]." + ".$word[2]." + ". $word[3]." + ".$word[4];
      }
    }
	}

?>


</body>
</html>
