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
		
		if(empty($class_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_class_update=$con->select_query("pathshala_class","*"," Where class_id='".$class_id."'");
			$classdetail = mysqli_fetch_assoc($query_class_update);
			if(empty($classdetail))
			{
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'Class  are not available.'));
				
			}
			else
			{
				if ($classdetail['class_status']==1)
				{
					$y=0;
					$classstatus = array(
							"class_status"=>$y
					);
					$updateclass = $con->update("pathshala_class",$classstatus,"where class_id='".$class_id."'");

					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"Class deactive Successfully."));

				}
				else
				{
					$x=1;
					$classstatus = array(
							"class_status"=>$x
					);
					$updateclass = $con->update("pathshala_class",$classstatus,"where class_id='".$class_id."'");

					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"Class active Successfully."));
			}
			}	
		}

?>