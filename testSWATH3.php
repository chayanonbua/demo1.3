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

		$countSen=0;$countS = 0;$countV = 0;$countCON=0;$countO=0;$countNEG=0;$countP=0;$countINO=0;$countCL=0;$countNUM=0;
    	 	if(isset($_POST['submit']))
	 	$input = $_POST['input'];
		$ans=swath($input);
		$count = 1;

		//echo array_search('V',$sentenceRole);
		function start($input){

          global $word;
          $object;
					$ans=swath($input);
					$count = 0;
          $TSSentece="";

					foreach($ans as $value){
						$swathWord = preg_split("/[@]/", $value, 0, PREG_SPLIT_NO_EMPTY);
						$word[$count] = $swathWord[0];
						$role[$count] = $swathWord[1];
						$sentenceRole[$count] = SetSentenceRole($role[$count],$word[$count],$word[$count-1],$sentenceRole[$count-1],$count);
						//echo "�ӷ�� ".$count ." ". $word[$count]. " ˹�ҷ�� ".$role[$count]. " ˹�ҷ��㹻���¤ ".$sentenceRole[$count]."<br>";

            $GLOBALS['$ALLSentenceRole'] = $GLOBALS['$ALLSentenceRole'] . $sentenceRole[$count];
						$count=$count+1;
					}
          $word=array_values($word);
          if($GLOBALS['countCL']>0){
                for($i=1;$i<=$GLOBALS['countCL'];$i++){

                    $GLOBALS['$ALLSentenceRole'] = checkNUM($GLOBALS['$ALLSentenceRole'],$word);

                }
          }

          if($GLOBALS['countCON']>0){

               if($GLOBALS['countSen']>0){
                 $GLOBALS['$ALLSentenceRole'] = checkCON($GLOBALS['$ALLSentenceRole'],$word);
                 $subSentenceRole = explode("C",($GLOBALS['$ALLSentenceRole']));
                 for($i=1;$i<=$GLOBALS['countSen']+1;$i++){

                        $TSSentence = $TSSentence." + ".GetTSSentence($subSentenceRole[$i-1],$word,$i-1);
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

	function SetSentenceRole($input,$token,$wordBefore,$roleBefore,$count){
    global $subject;global $verb;global $object;global $conjunction;global $NEG;global $pre;global $inObject;global $clssifier;global $number;global $word;
		if($input=="PPRS" || $input=="NCMN" ){
      if($GLOBALS['countP']>$GLOBALS['countINO']){
        $inObject[$GLOBALS['countINO']]=$token." + CL(inO)";
        $GLOBALS['countINO']=$GLOBALS['countINO']+1;
        return "I";
			}
      else if($GLOBALS['countS']>0 && $GLOBALS['countV']>0 ){
        $object[$GLOBALS['countO']]=$token." + CL(O)";
        $GLOBALS['countO']=$GLOBALS['countO']+1;
        return "O";
			}
      else if($GLOBALS['countS']==0 || ($GLOBALS['countS']==1 && $GLOBALS['countV']==1&& $GLOBALS['countO']==1)  ){
        $subject[$GLOBALS['countS']]=$token;
				$GLOBALS['countS']=$GLOBALS['countS']+1;
				return "S";
			}

			else if($GLOBALS['countS']==1 && $GLOBALS['countCON']==1){
        $subject[$GLOBALS['countS']]=$token;
        $GLOBALS['countS']=$GLOBALS['countS']+1;
        return "S";
			}


		}
		else if($input=="VACT" || $input=="VSTA" /*|| $input=="VATT"*/){
      $verb[$GLOBALS['countV']] = $token;
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
      $NEG[$GLOBALS['countNEG']] = $token;
      $GLOBALS['countNEG'] = $GLOBALS['countNEG']+1;
			return "NEG";
		}
    else if($input=="JCRG" || $input=="JCMP" || $input=="JSRB" ){
      $conjunction[$GLOBALS['countCON']] = $token;
      //$GLOBALS['countS']=1;
      $GLOBALS['countCON']=$GLOBALS['countCON']+1;
      return "C";
    }
    else if($input=="ADVN" || $input=="VATT"  ){
      //return "ADJ";
      //return $roleBefore;
      if($roleBefore=="S"){
          $subject[$GLOBALS['countS']-1] = $subject[$GLOBALS['countS']-1].".".$token;
      }else if($roleBefore=="V"){
          $verb[$GLOBALS['countV']-1] = $verb[$GLOBALS['countV']-1].".".$token;
      }
      else if($roleBefore=="O"){

          $object[$GLOBALS['countO']-1] = substr($object[$GLOBALS['countO']-1],0,strpos($object[$GLOBALS['countO']-1]," +"));
          $object[$GLOBALS['countO']-1] = $object[$GLOBALS['countO']-1].".".$token." + CL(O)";
      }

      unset($word[$count]);



    }
    elseif ($input=="RPRE") {
          $pre[$GLOBALS['countP']] = $token;
          $object[$GLOBALS['countO']-1] = substr($object[$GLOBALS['countO']-1],0,strpos($object[$GLOBALS['countO']-1]," + "))." + " .$token ." +  CL(O)";
          $GLOBALS['countP']=$GLOBALS['countP']+1;
          return "PRE";
    }
    else if($input=="DCNM"){
      $number[$GLOBALS['countNUM']] = $token;
      $GLOBALS['countNUM'] = $GLOBALS['countNUM']+1;
			return "D";
		}
    else if($input=="CNIT" || $input=="CLTV" || $input=="CMTR" || $input=="CFQC" || $input=="CVBL"){
      $clssifier[$GLOBALS['countCL']] = $token;
      $GLOBALS['countCL'] = $GLOBALS['countCL']+1;
			return "L";
		}
		else{
			return(" ".$input." ");
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
      else if ($word=="I"){
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
    global $subject;global $object;global $clssifier;global $verb;
        if(strpos($SentenceRole,'C')){
            $subRoleSen = explode("C", $SentenceRole);
            //$posCON = strpos($SentenceRole,"C",1)+1; //
            //$subSen = explode($word[$posCON], $word);
                    if($GLOBALS['countCON']>=1){
                        for($i=0;$i<$GLOBALS['countCON'];$i++){
                                    if ( (strpos($SentenceRole,"SCS")) !== false ){
                                      //$subject[$GLOBALS['countS']-2]=$word[$posCON-1].$word[$posCON].$word[$posCON+1];
                                      $posCON = strpos($SentenceRole,"SCS",1)+1;
                                      $posS1 = strpos($SentenceRole,"SCS",1);
                                      $posS2 = strpos($SentenceRole,"SCS",1)+2;

                                      $tempO1 = preg_quote($word[$posS1], '~');
                                      $tempO2 = preg_quote($word[$posS2], '~');

                                      $posArrS1 = key(preg_grep('~' . $tempO1 . '~', $subject));
                                      $posArrS2 = key(preg_grep('~' . $tempO2 . '~', $subject));



                                      $subject[$posArrS1]=$subject[$posArrS1]." + ".$word[$posCON]." + ".$subject[$posArrS2];

                                      unset($subject[$posArrS2]);
                                      $subject=array_values($subject);


                                      //$subject[$GLOBALS['countS']-2]=$subject[$GLOBALS['countS']-2]." + ".$word[$posCON]." + ".$subject[$GLOBALS['countS']-1];
                                      //$GLOBALS['$ALLSentenceRole'] = str_replace("SCONS","S",$SentenceRole);
                                      $SentenceRole = str_replace("SCS","S",$SentenceRole);
                                    }
                                    else if ( (strpos($SentenceRole,"VCV")) !== false ){
                                      //$subject[$GLOBALS['countS']-2]=$word[$posCON-1].$word[$posCON].$word[$posCON+1];
                                      $posCON = strpos($SentenceRole,"VCV",1)+1;
                                      $posV1 = strpos($SentenceRole,"VCV",1);
                                      $posV2 = strpos($SentenceRole,"VCV",1)+2;

                                      $tempO1 = preg_quote($word[$posV1], '~');
                                      $tempO2 = preg_quote($word[$posV2], '~');

                                      $posArrV1 = key(preg_grep('~' . $tempO1 . '~', $verb));
                                      $posArrV2 = key(preg_grep('~' . $tempO2 . '~', $verb));



                                      $verb[$posArrV1]=$verb[$posArrV1]." + ".$word[$posCON]." + ".$verb[$posArrV2];

                                      unset($verb[$posArrS2]);
                                      $verb=array_values($verb);


                                      //$subject[$GLOBALS['countS']-2]=$subject[$GLOBALS['countS']-2]." + ".$word[$posCON]." + ".$subject[$GLOBALS['countS']-1];
                                      //$GLOBALS['$ALLSentenceRole'] = str_replace("SCONS","S",$SentenceRole);
                                      $SentenceRole = str_replace("VCV","V",$SentenceRole);
                                    }
                                    else if ( ((strpos($SentenceRole,"OCO")) !== false)  ) {

                                        $posCON = strpos($SentenceRole,"OCO",1)+1;
                                        $posO1 = strpos($SentenceRole,"OCO",1);
                                        $posO2 = strpos($SentenceRole,"OCO",1)+2;

                                        $tempO1 = preg_quote($word[$posO1], '~');
                                        $tempO2 = preg_quote($word[$posO2], '~');

                                        $posArrO1 = key(preg_grep('~' . $tempO1 . '~', $object));
                                        $posArrO2 = key(preg_grep('~' . $tempO2 . '~', $object));

                                        //$posArrO1 = array_search($word[$posO1]." + CL(O)",$object);
                                        //$posArrO2 = array_search($word[$posO2]." + CL(O)",$object);

                                        if($GLOBALS['countCL']>0){
                                            for($i=0;$i<$GLOBALS['countCL'];$i++){
                                                $tempCL = preg_quote($clssifier[$i], '~');
                                                if( ((strpos($object[$posArrO1],$clssifier[$i])) !== false) ){
                                                    $object[$posArrO1]=$word[$posO1]." + ".$word[$posCON]." + ";
                                                }
                                                else{
                                                    $object[$posArrO1]=$word[$posO1]." + CL(O) + ".$word[$posCON]." + ";
                                                }
                                                if( ((strpos($object[$posArrO2],$clssifier[$i])) !== false) ){
                                                    $object[$posArrO1].=$word[$posO2];
                                                }
                                                else{
                                                    $object[$posArrO1].=$word[$posO2]." + CL(O)";
                                                }
                                            }
                                        }
                                        else {
                                                $object[$posArrO1]=$word[$posO1]." + CL(O) + ".$word[$posCON]." + ".$word[$posO2]." + CL(O)";
                                        }




                                        unset($object[$posArrO2]);
                                        $object=array_values($object);


                                        $SentenceRole = str_replace("OCO","O",$SentenceRole);
                                    }
                                    else {
                                      return $SentenceRole;
                                    }
                        }
                        return $SentenceRole;
                    }
                    else{
                      return $SentenceRole;
                    }
        }
        else {
          return $SentenceRole;
        }
   }

  function checkNUM($SentenceRole,$input){
    global $object;global $number;global $clssifier;global $word;
      if ( (strpos($SentenceRole,"ODL")) !== false ){


          $posO = strpos($SentenceRole,"ODL",1);
          $posD = strpos($SentenceRole,"ODL",1)+1;
          $posL = strpos($SentenceRole,"ODL",1)+2;
          $tempO = preg_quote($input[$posO], '~');


          $posArrO = key(preg_grep('~' . $tempO . '~', $object));

          $object[$posArrO]=$input[$posO]." + ". $input[$posD] ." + ".$input[$posL];
          $word[$posO]=$input[$posO]." + ". $input[$posD] ." + ".$input[$posL];

          unset($word[$posD]);
          unset($word[$posL]);
          $word=array_values($word);

          //$SentenceRole = str_replace("ODL","O",$SentenceRole);
          $SentenceRole = preg_replace('/ODL/',"O",$SentenceRole,1);

          return $SentenceRole;
      }
      else{
        return $sentenceRole;
      }
  }

	function GetTSSentence($ALLSentenceRole,$word,$sentenNum){
      global $role;
      if($ALLSentenceRole=="SV" || $ALLSentenceRole=="SVV"){
        return GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum);
      }
      else if($ALLSentenceRole=="SVPREI" || $ALLSentenceRole=="SVVPREI"){
        return GetSentenceRole("I",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum);
      }
      else if($ALLSentenceRole=="SNEGVPREI" || $ALLSentenceRole=="SNEGVVPREI"){
        return GetSentenceRole("I",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum)." + ".GetSentenceRole("NEG",$sentenNum);
      }
      else if ($ALLSentenceRole=="SNEGV"){
        return GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("NEG",$sentenNum)." + ".GetSentenceRole("V",$sentenNum);
        // S + NEG + V
      }
      else if ($ALLSentenceRole=="SVO"){
        return GetSentenceRole("O",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum);
        // O+CL+S+V
      }
      else if ($ALLSentenceRole=="SVOPREI"){
        return GetSentenceRole("I",$sentenNum)." + ".GetSentenceRole("O",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum);
        // inO + CL(inO) + O + PRE + CL(O) + S + V
      }
      else if ($ALLSentenceRole=="SNEGVO"){
        return GetSentenceRole("O",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum)." + ".GetSentenceRole("NEG",$sentenNum);
         // O+CL+S+V+NEG
      }
      else if ($ALLSentenceRole=="SNEGVOPREI"){
        return GetSentenceRole("I",$sentenNum)." + ".GetSentenceRole("O",$sentenNum)." + ".GetSentenceRole("S",$sentenNum)." + ".GetSentenceRole("V",$sentenNum)." + ".GetSentenceRole("NEG",$sentenNum);
        // inO + CL(inO) + O + PRE + CL(O) + S + V + NEG
      }
      else{
        //return $word[1]." + ".$word[2];
        //return $ALLSentenceRole . "ไม่สามารถแปลประโยคได้ เนื่องจากไม่ต้องกับประโยคไม่ตรงกับข้อกำหนด";
        return $ALLSentenceRole . " = " . print_r($role);
      }
	}

?>


</body>
</html>
