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

 
     	$quiz_name = $input_params['quiz_name'];

		$teacher_id=$input_params['teacher_id'];
		
		$class_id=$input_params['class_id'];
		
		if(empty($quiz_name) || empty($teacher_id) || empty($class_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
						$addquiz=array("quiz_name"=>$quiz_name,

									"class_id"=>$class_id,

									"teacher_id"=>$teacher_id
							 	);
					 		// echo $addquestion;die();
					 	$quizinsert=$con->insert_record("quiz",$addquiz);
					 	
					 	$quiz_id = $con->last_inserted_id($quizinsert);
						
					 	$quizview=$con->select_query("quiz","*","where quiz_id=".$quiz_id);

					 	$quiz=mysqli_fetch_array($quizview);
					 	
					 	$quizdetail=array(
					 		"quiz_id"=>intval($quiz['quiz_id']),
					 		"quiz_name"=>$quiz['quiz_name']
					 	);

					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"quiz"=>$quizdetail,"message"=>"Quiz added Successfully."));
			
			}	

?>