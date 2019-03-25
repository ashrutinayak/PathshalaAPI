<?php

$file = fopen("php://input","r");

$jsonInput ="";

while(!feof($file))
{
	$jsonInput .= fgets($file);	
}

fclose($file);

	$input_params = json_decode($jsonInput,true);
    


    include("includes/common_class.php");
	include("includes/config.php");

		$quiz_id = $input_params['quiz_id'];
 
		$question_name=$input_params['question_name'];
		
		$optionA=$input_params['optionA'];
		
		$optionB=$input_params['optionB'];
		
		$optionC=$input_params['optionC'];
		
		$optionD=$input_params['optionD'];

		$answer=$input_params['answer'];

		$question_Detail=$input_params['question_Detail'];
		

		if(empty($quiz_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
				$questiondetails = array(

									"quiz_id"=>$quiz_id,

									$question_name=array(
					 		
								 		"question_name"=>$question_name,
								 		
								 		"optionA"=>$optionA,
								 		
								 		"optionB"=>$optionB,
								 		
								 		"optionC"=>$optionC,
								 		
								 		"optionD"=>$optionD,
								 		
								 		"answer"=>$answer

								 )
						);
				if($question_name!=0)
				{
					foreach($questiondetails as $row)
					{
						$quiz_id=$quiz_id;
						// echo $quiz_id;die();
						foreach($row['question_name'] as $row1)
						{
							$question_name=$row1['question_name'];
							$optionA=$row1['optionA'];
							$optionB=$row1['optionB'];
							$optionC=$row1['optionC'];
							$optionD=$row1['optionD'];
							$answer=$row1['answer'];
						 // echo $optionA;die();
							$arrquestion=array(
									"quiz_id"=>$quiz_id,
									"question_name"=>$question_name,
									"optionA"=>$optionA,
									"optionB"=>$optionB,
									"optionC"=>$optionC,
									"optionD"=>$optionD,
									"answer"=>$answer
							);
							$insertattendance=$con->insert_record("question",$arrquestion);
						}
					}
					
					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"Quiz question added Successfully."));
			
			}	
			else
			{
				header('Content-type: application/json');

					echo json_encode(array("status"=>0,"message"=>"No Quiz question added Successfully."));

			}
}
?>