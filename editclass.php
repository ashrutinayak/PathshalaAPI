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

		
		$class_name=$input_params['class_name'];
		
		$class_id=$input_params['class_id'];
		
		if(empty($class_id) || empty($class_name) )
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
				$x=1;
				$ClassDetail = array(

									"class_name"=>$class_name,
									
								);
					$updateclass = $con->update("pathshala_class",$ClassDetail,"where class_id='".$class_id."'");

					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"Class update Successfully."));
			
			}	
		}

?>