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
		
		$module_id=$input_params['module_id'];

		if(empty($class_id) ||empty($student_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}

		else
		{
			$query_module_update=$con->select_query("module_add","*"," Where class_id='".$class_id."' and student_id='".$student_id."' and module_id='".$module_id."'");
			$moduledetail = mysqli_fetch_assoc($query_module_update);
			if(empty($moduledetail))
			{
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'Module  are not available.'));
				
			}
			else
			{
				if ($moduledetail['module_status']==1)
				{
					
					header('Content-type: application/json');

					echo json_encode(array("status"=>0,"message"=>"Module are already completed."));

				}
				else
				{
					$x=1;
					$moduletatus = array(
							"module_status"=>$x
					);
					$updateclass = $con->update("module_add",$moduletatus,"where class_id='".$class_id."' and student_id='".$student_id."' and module_id='".$module_id."'");

					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"Module completed Successfully."));
			}
			}	
		}

?>