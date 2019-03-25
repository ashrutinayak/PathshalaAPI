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

    	
		// $quiz_id=$input_params['quiz_id'];\
		$teacher_id=$input_params['teacher_id'];
		$class_id=$input_params['class_id'];


		if(empty($class_id) ||empty($teacher_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_quiz=$con->select_query("quiz","*"," Where class_id='".$class_id."' and teacher_id='".$teacher_id."'");
			if($con->total_records($query_quiz) != 0)
			{
				$x=0;
				$QuizList=array();
				while($row_quiz = mysqli_fetch_array($query_quiz))
				{

					
						$QuizList[$x]["quiz_id"]=intval($row_quiz['quiz_id']);
						$QuizList[$x]["quiz_name"]=$row_quiz['quiz_name'];
						  $x++;
						// }
					}
					header('Content-type: application/json');
					echo json_encode(array("status"=>1,"quiz"=>$QuizList,"message"=>"Quiz Listed Successfully."));
				}
				else
				{
					header('Content-type: application/json');
              		echo json_encode(array("status"=>0,"message"=>"Quiz are not Available!!!"));
				}

	}
?>
