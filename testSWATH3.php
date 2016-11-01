<?php

define('SWATH', 'C:\\AppServ\\www\\Thesis\\demo1.3');
?>
<html>
<head>
<meta charset="UTF-8" />
</head>
<body>

     <?php
	 	$word;	$role; $sentenceRole;$ALLSentence;$ALLSentenceRole=""; $subject;$verb; $object;$inObject; $conjunction; $adjective;$NEG;$pre;$clssifier;$number;

		$countSen=1;$countS = 1;$countV = 1;$countCON=1;$countO=1;$countNEG=1;$countP=1;$countINO=1;$countCL=1;$countNUM=1;
    	 	if(isset($_POST['submit']))
	 	$input = $_POST['input'];
		$ans=swath($input);
		$count = 1;

		//echo array_search('V',$sentenceRole);
		function start($input){

					$ans=swath($input);
					$count = 1;
          $TSSentece="";

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

               if($GLOBALS['countSen']>1){
                 $GLOBALS['$ALLSentenceRole'] = checkCON($GLOBALS['$ALLSentenceRole'],$word);
                 $subSentenceRole = explode("C",($GLOBALS['$ALLSentenceRole']));
                 for($i=1;$i<=$GLOBALS['countSen'];$i++){

                        $TSSentence = $TSSentence." + ".GetTSSentence($subSentenceRole[$i-1],$word,$i);
                        //$TSSentence=$subSentenceRole[0];
                 }
               }
               else{
                 $GLOBALS['$ALLSentenceRole'] = checkCON($GLOBALS['$ALLSentenceRole'],$word);
                 $TSSentence = GetTSSentence($GLOBALS['$ALLSentenceRole'],$word,$GLOBALS['countSen']);
               }

               return $TSSentence;
          }
          else{
              return GetTSSentence($GLOBALS['$ALLSentenceRole'],$word,$GLOBALS['countSen']);
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
    global $subject;global $verb;global $object;global $conjunction;global $NEG;global $pre;global $inObject;global $clssifier;global $number;
		if($input=="PPRS" || $input=="NCMN" ){
      if($GLOBALS['countP']==2){
        $inObject[$GLOBALS['countINO']]=$word." + CL(inO)";
        $GLOBALS['countINO']=$GLOBALS['countINO']+1;
        return "INO";
			}
      else if($GLOBALS['countS']>1 && $GLOBALS['countV']>1 ){
        $object[$GLOBALS['countO']]=$word." + CL(O)";
        $GLOBALS['countO']=$GLOBALS['countO']+1;
        return "O";
			}
      else if($GLOBALS['countS']==1 || ($GLOBALS['countS']==2 && $GLOBALS['countV']==2&& $GLOBALS['countO']==2)  ){
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

        if($roleBefore=="O"){
          $GLOBALS['$ALLSentenceRole'] = substr($GLOBALS['$ALLSentenceRole'],0,-1);

          $subject[$GLOBALS['countS']]=substr($object[$GLOBALS['countO']-1],0,strpos($object[$GLOBALS['countO']-1]," "));
          $GLOBALS['countS']=$GLOBALS['countS']+1;

          $object[$GLOBALS['countO']-1] = "";
          $GLOBALS['countO'] = $GLOBALS['countO']-1;

          $GLOBALS['countSen'] = $GLOBALS['countSen']+1;

          return "SV";
        }
        else {
          return "V";
        }

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
      return "C";
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
    else if($input=="DCNM"){
      $number[$GLOBALS['countNUM']] = $word;
      $GLOBALS['countNUM'] = $GLOBALS['countNUM']+1;
			return "D";
		}
    else if($input=="CNIT" || $input=="CLTV" || $input=="CMTR" || $input=="CFQC" || $input=="CVBL"){
      $clssifier[$GLOBALS['countCL']] = $word;
      $GLOBALS['countCL'] = $GLOBALS['countCL']+1;
			return "L";
		}
		else{
			return("x =".$input);
		}
	}

  function GetSentenceRole($word,$count){
    global $subject;global $verb;global $object;global $conjunction;global $NEG;global $pre;global $inObject;global $clssifier;global $number;
      if($word=="S"){
        return $subject[$count];
      }
      else if ($word=="V"){
        return  $verb[$count];
      }
      else if ($word=="O"){
        return  $object[$count];
      }
      else if ($word=="C"){
        return  $conjunction[$count];
      }
      else if ($word=="NEG"){
        return  $NEG[$count];
      }
      else if ($word=="PRE"){
        return  $pre[$count];
      }
      else if ($word=="INO"){
        return  $inObject[$count];
      }
      else if ($word=="D"){
        return  $number[$count];
      }
      else if ($word=="L"){
        return  $clssifier[$count];
      }
  }

  function checkCON($SentenceRole,$word){
    global $subject;global $object;
        if(strpos($SentenceRole,'C')){
            $subRoleSen = explode("C", $SentenceRole);
            //$posCON = strpos($SentenceRole,"C",1)+1; //
            //$subSen = explode($word[$posCON], $word);
                    if($GLOBALS['countCON']>=2){
                        for($i=0;$i<$GLOBALS['countCON'];$i++){
                                    if ( (strpos($SentenceRole,"SCS")) !== false ){
                                      //$subject[$GLOBALS['countS']-2]=$word[$posCON-1].$word[$posCON].$word[$posCON+1];
                                      $posCON = strpos($SentenceRole,"SCS",1)+2;
                                      $subject[$GLOBALS['countS']-2]=$subject[$GLOBALS['countS']-2]." + ".$word[$posCON]." + ".$subject[$GLOBALS['countS']-1];
                                      //$GLOBALS['$ALLSentenceRole'] = str_replace("SCONS","S",$SentenceRole);
                                      $SentenceRole = str_replace("SCS","S",$SentenceRole);
                                    }
                                    else if ( ((strpos($SentenceRole,"OCO")) !== false)  ) {

                                        $posCON = strpos($SentenceRole,"OCO",1)+2;
                                        $posO1 = strpos($SentenceRole,"OCO",1)+1;
                                        $posO2 = strpos($SentenceRole,"OCO",1)+3;
                                        $posArrO1 = array_search($word[$posO1]." + CL(O)",$object);
                                        $posArrO2 = array_search($word[$posO2]." + CL(O)",$object);


                                        $object[$posArrO1]=$word[$posO1]." + CL(O) + ".$word[$posCON]." + ".$word[$posO2]." + CL(O)";


                                        unset($object[$posArrO2]);
                                        $object=array_values($object);
                                        print_r($object);

                                        $SentenceRole = str_replace("OCO","O",$SentenceRole);
                                    }
                                    else {
                                      return $SentenceRole;
                                    }
                        }
                    }
                    else{
                      return $SentenceRole;
                    }
        }
        else {
          return $SentenceRole;
        }
   }

  function checkNUM($SentenceRole,$word){
    global $object;global $number;global $clssifier;
    for($i=0;$i<$GLOBALS['countCON'];$i++){
      if ( (strpos($SentenceRole,"ODL")) !== false ){
          $posCON = strpos($SentenceRole,"ODL",1)+1;
      }
    }
  }

	function GetTSSentence($ALLSentenceRole,$word,$sentenNum){

      if($ALLSentenceRole=="SV" || $ALLSentenceRole=="SVV"){
        return GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum);
      }
      else if($ALLSentenceRole=="SVPREINO" || $ALLSentenceRole=="SVVPREINO"){
        return GetSentenceRole("INO",1)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum);
      }
      else if($ALLSentenceRole=="SNEGVPREINO" || $ALLSentenceRole=="SNEGVVPREINO"){
        return GetSentenceRole("INO",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum)." + ".GetSentenceRole("NEG",$sentenNum);
      }
      else if ($ALLSentenceRole=="SNEGV"){
        return GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("NEG",$sentenNum)." + ".GetSentenceRole("V",$sentenNum);
        // S + NEG + V
      }
      else if ($ALLSentenceRole=="SVO"){
        return GetSentenceRole("O",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum);
        // O+CL+S+V
      }
      else if ($ALLSentenceRole=="SVOPREINO"){
        return GetSentenceRole("INO",$sentenNum)." + ".GetSentenceRole("O",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum);
        // inO + CL(inO) + O + PRE + CL(O) + S + V
      }
      else if ($ALLSentenceRole=="SNEGVO"){
        return GetSentenceRole("O",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum)." + ".GetSentenceRole("NEG",$sentenNum);
         // O+CL+S+V+NEG
      }
      else if ($ALLSentenceRole=="SNEGVOPREINO"){
        return GetSentenceRole("INO",$sentenNum)." + ".GetSentenceRole("O",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum)." + ".GetSentenceRole("NEG",$sentenNum);
        // inO + CL(inO) + O + PRE + CL(O) + S + V + NEG
      }
      else{
        //return $word[1]." + ".$word[2];
        //return $ALLSentenceRole . "ไม่สามารถแปลประโยคได้ เนื่องจากไม่ต้องกับประโยคไม่ตรงกับข้อกำหนด";
        return $GLOBALS['$ALLSentenceRole'] . " = " . print_r($word) .GetSentenceRole("S",2) ;
      }
	}

?>


</body>
</html>
