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

    	
		$quiz_id=$input_params['quiz_id'];


		if(empty($quiz_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_quiz=$con->select_query("question","*","INNER JOIN `quiz` ON `quiz`.`quiz_id`=`question`.`quiz_id` Where `question`.`quiz_id`='".$quiz_id."'");
			if($con->total_records($query_quiz) != 0)
			{
				$x=0;
				$QuizList=array();
				while($row_quiz = mysqli_fetch_array($query_quiz))
				{

					
						$QuizList[$x]["question_id"]=intval($row_quiz['question_id']);
						$QuizList[$x]["quiz_name"]=$row_quiz['quiz_name'];
						$QuizList[$x]["question_name"]=$row_quiz['question_name'];
						$QuizList[$x]["optionA"]=$row_quiz['optionA'];
						$QuizList[$x]["optionB"]=$row_quiz['optionB'];
						$QuizList[$x]["optionC"]=$row_quiz['optionC'];
						$QuizList[$x]["optionD"]=$row_quiz['optionD'];
						$QuizList[$x]["answer"]=$row_quiz['answer'];
						  $x++;
						// }
					}
					header('Content-type: application/json');
					echo json_encode(array("status"=>1,"question"=>$QuizList,"message"=>"Question Listed Successfully."));
				}
				else
				{
					header('Content-type: application/json');
              		echo json_encode(array("status"=>0,"message"=>"Question are not Available!!!"));
				}

	}
?>
