<?php

define('SWATH', 'C:\\AppServ\\www\\Thesis\\demo1.3');
?>
<html>
<head>
<meta charset="UTF-8" />
</head>
<body>

     <?php
	 	$word;	$role; $sentenceRole;$ALLSentence;$ALLSentenceRole=""; $subject;$verb; $object;$inObject; $conjunction; $adjective;$NEG;$pre;

		$countS = 1;$countV = 1;$countCON=1;$countO=1;$countNEG=1;$countP=1;$countINO=1;
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
						$sentenceRole[$count] = SetSentenceRole($role[$count],$word[$count],$word[$count-1],$sentenceRole[$count-1]);
						//echo "�ӷ�� ".$count ." ". $word[$count]. " ˹�ҷ�� ".$role[$count]. " ˹�ҷ��㹻���¤ ".$sentenceRole[$count]."<br>";

            $GLOBALS['$ALLSentenceRole'] = $GLOBALS['$ALLSentenceRole'] . $sentenceRole[$count];
						$count=$count+1;
					}

          if($GLOBALS['countCON']>1){
               checkCON($GLOBALS['$ALLSentenceRole'],$word);
               return GetTSSentence($GLOBALS['$ALLSentenceRole'],$word);
          }
          else{
              return GetTSSentence($GLOBALS['$ALLSentenceRole'],$word);
          }



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

	function SetSentenceRole($input,$word,$wordBefore,$roleBefore){
    global $subject;global $verb;global $object;global $conjunction;global $NEG;global $pre;global $inObject;
		if($input=="PPRS" || $input=="NCMN" ){
      if($GLOBALS['countP']==2){
        $inObject[$GLOBALS['countINO']]=$word." + CL(inO)";
        $GLOBALS['countINO']=$GLOBALS['countINO']+1;
        return "INO";
			}
      else if($GLOBALS['countS']>1 && $GLOBALS['countV']>1){
        $object[$GLOBALS['countO']]=$word." + CL(O)";
        $GLOBALS['countO']=$GLOBALS['countO']+1;
        return "O";
			}
      else if($GLOBALS['countS']==1 || ($GLOBALS['countS']==2 && $GLOBALS['countV']==2&& $GLOBALS['countO']==2)){
        $subject[$GLOBALS['countS']]=$word;
				$GLOBALS['countS']=$GLOBALS['countS']+1;
				return "S";
			}

			else if($GLOBALS['countS']==2 && $GLOBALS['countCON']==2){
        $subject[$GLOBALS['countS']]=$word;
        $GLOBALS['countS']=$GLOBALS['countS']+1;
        return "S";
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
      $conjunction[$GLOBALS['countCON']] = $word;
      //$GLOBALS['countS']=1;
      $GLOBALS['countCON']=$GLOBALS['countCON']+1;
      return "CON";
    }
    else if($input=="ADVN" || $input=="VATT"  ){
      //return "ADJ";
      //return $roleBefore;
      if($roleBefore=="S"){
          $subject[$GLOBALS['countS']-1] = $subject[$GLOBALS['countS']-1].".".$word;
      }else if($roleBefore=="V"){
          $verb[$GLOBALS['countV']-1] = $verb[$GLOBALS['countV']-1].".".$word;
      }
      else if($roleBefore=="O"){
          $object[$GLOBALS['countO']-1] = $object[$GLOBALS['countO']-1].".".$word;
      }
    }
    elseif ($input=="RPRE") {
          $pre[$GLOBALS['countP']] = $word;
          $object[$GLOBALS['countO']-1] = substr($object[$GLOBALS['countO']-1],0,strpos($object[$GLOBALS['countO']-1]," + "))." + " .$word ." +  CL(O)";
          $GLOBALS['countP']=$GLOBALS['countP']+1;
          return "PRE";
    }
		else{
			return("x =".$input);
		}
	}

  function GetSentenceRole($word,$number){
    global $subject;global $verb;global $object;global $conjunction;global $NEG;global $pre;global $inObject;
      if($word=="S"){
        return $subject[$number];
      }
      else if ($word=="V"){
        return  $verb[$number];
      }
      else if ($word=="O"){
        return  $object[$number];
      }
      else if ($word=="CON"){
        return  $conjunction[$number];
      }
      else if ($word=="NEG"){
        return  $NEG[$number];
      }
      else if ($word=="PRE"){
        return  $pre[$number];
      }
      else if ($word=="INO"){
        return  $inObject[$number];
      }
  }

  function checkCON($SentenceRole,$word){
    global $subject;global $object;
        if(strpos($SentenceRole,'CON')){
            $subRoleSen = explode("CON", $SentenceRole);
            $posCON = strpos($SentenceRole,"CON",1)+1; //
            //$subSen = explode($word[$posCON], $word);
            if($posCON>1){

                if ( (strpos($SentenceRole,"SCONS")) !== false ){
                  //$subject[$GLOBALS['countS']-2]=$word[$posCON-1].$word[$posCON].$word[$posCON+1];
                  $subject[$GLOBALS['countS']-2]=$subject[$GLOBALS['countS']-2]." + ".$word[$posCON]." + ".$subject[$GLOBALS['countS']-1];
                  $GLOBALS['$ALLSentenceRole'] = str_replace("SCONS","S",$SentenceRole);
                }
                else if ((strpos($SentenceRole,"OCONO")) !== false) {

                    $object[$GLOBALS['countO']-2]=$object[$GLOBALS['countO']-2]." + ".$word[$posCON]." + ".$object[$GLOBALS['countO']-1];
                    $GLOBALS['$ALLSentenceRole'] = str_replace("OCONO","O",$SentenceRole);
                }
            }
          }
   }

	function GetTSSentence($ALLSentenceRole,$word){

      if($ALLSentenceRole=="SV" || $ALLSentenceRole=="SVV"){
        return GetSentenceRole("S",1)." + ".GetSentenceRole("V",1);
      }
      else if($ALLSentenceRole=="SVPREINO" || $ALLSentenceRole=="SVVPREINO"){
        return GetSentenceRole("INO",1)." + ".GetSentenceRole("S",1)." + ".GetSentenceRole("V",1);
      }
      else if($ALLSentenceRole=="SNEGVPREINO" || $ALLSentenceRole=="SNEGVVPREINO"){
        return GetSentenceRole("INO",1)." + ".GetSentenceRole("S",1)." + ".GetSentenceRole("V",1)." + ".GetSentenceRole("NEG",1);
      }
      else if ($ALLSentenceRole=="SNEGV"){
        return GetSentenceRole("S",1)." + ".GetSentenceRole("NEG",1)." + ".GetSentenceRole("V",1);
        // S + NEG + V
      }
      else if ($ALLSentenceRole=="SVO"){
        return GetSentenceRole("O",1)." + ".GetSentenceRole("S",1)." + ".GetSentenceRole("V",1);
        // O+CL+S+V
      }
      else if ($ALLSentenceRole=="SVOPREINO"){
        return GetSentenceRole("INO",1)." + ".GetSentenceRole("O",1)." + ".GetSentenceRole("S",1)." + ".GetSentenceRole("V",1);
        // inO + CL(inO) + O + PRE + CL(O) + S + V
      }
      else if ($ALLSentenceRole=="SNEGVO"){
        return GetSentenceRole("O",1)." + ".GetSentenceRole("O",1)." + ".GetSentenceRole("S",1)." + ".GetSentenceRole("V",1)." + ".GetSentenceRole("NEG",1);
         // O+CL+S+V+NEG
      }
      else if ($ALLSentenceRole=="SNEGVOPREINO"){
        return GetSentenceRole("INO",1)." + ".GetSentenceRole("O",1)." + ".GetSentenceRole("S",1)." + ".GetSentenceRole("V",1)." + ".GetSentenceRole("NEG",1);
        // inO + CL(inO) + O + PRE + CL(O) + S + V + NEG
      }
      else{
        //return $word[1]." + ".$word[2];
        //return $ALLSentenceRole . "ไม่สามารถแปลประโยคได้ เนื่องจากไม่ต้องกับประโยคไม่ตรงกับข้อกำหนด";
        return $GLOBALS['$ALLSentenceRole'] . " = " . print_r($word);
      }
	}

?>


</body>
</html>
