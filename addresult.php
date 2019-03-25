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

 
     	$student_id = $input_params['student_id'];

		$quiz_id=$input_params['quiz_id'];
		
		$class_id=$input_params['class_id'];
		
		$score=$input_params['score'];
		
		if(empty($score) || empty($quiz_id) || empty($class_id) || empty($student_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
						$addresult=array("quiz_id"=>$quiz_id,

									"class_id"=>$class_id,

									"student_id"=>$student_id,

									"score"=>$score
							 	);
					 		// echo $addquestion;die();
					 	$resultinsert=$con->insert_record("add_result",$addresult);
					 	
					 	// $quiz_id = $con->last_inserted_id($quizinsert);
						
					 	
					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"Result added Successfully."));
			
			}	

?>