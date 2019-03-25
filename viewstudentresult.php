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

    	
		$student_id=$input_params['student_id'];


		if(empty($student_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_result=$con->select_query("add_result","*","INNER JOIN quiz ON quiz.quiz_id=add_result.quiz_id Where add_result.student_id='".$student_id."'");
			if($con->total_records($query_result) != 0)
			{
				$x=0;
				$ResultList=array();
				while($row_result = mysqli_fetch_array($query_result))
				{
						$ResultList[$x]["result_id"]=intval($row_result['add_result_id']);
						$ResultList[$x]["quiz_name"]=$row_result['quiz_name'];
						$ResultList[$x]["score"]=intval($row_result['score']);
						 $x++;
					}
					header('Content-type: application/json');
					echo json_encode(array("status"=>1,"resultdetail"=>$ResultList,"message"=>"Student Result Listed Successfully."));
				}
				else
				{
					header('Content-type: application/json');
              		echo json_encode(array("status"=>0,"message"=>"Studet Result are not Available!!!"));
				}

	}
?>
