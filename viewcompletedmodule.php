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

    	
		$class_id=$input_params['class_id'];

		$student_id=$input_params['student_id'];

		if(empty($class_id) ||empty($student_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_module=$con->select_query("module_add","*","Where class_id='".$class_id."' and student_id='".$student_id."' and module_status=1");
			if($con->total_records($query_module) != 0)
			{
				$x=0;
				$ModuleList=array();
				while($row_module = mysqli_fetch_array($query_module))
				{
						$ModuleList[$x]["module_id"]=intval($row_module['module_id']);
						$ModuleList[$x]["module_name"]=$row_module['module_name'];
						$ModuleList[$x]["module_details"]=$row_module['module_details'];
						$ModuleList[$x]["module_status"]=intval($row_module['module_status']);
						 $x++;
					}
					header('Content-type: application/json');
					echo json_encode(array("status"=>1,"moduledetail"=>$ModuleList,"message"=>"Completed module Listed Successfully."));
				}
				else
				{
					header('Content-type: application/json');
              		echo json_encode(array("status"=>0,"message"=>"No module are Compelted."));
				}

	}
?>
