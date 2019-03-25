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
	//include("includes/connection.php");
	// include("includes/session.php");
	include("includes/config.php");
	// include("includes/check_admin_login.php");
	// include("includes/check_user_login.php");
	// include("includes/global.php");
	// include("include/function.php");



    	$sangh_id = $input_params['sangh_id'];

		$teacher_id=$input_params['teacher_id'];
		
		$class_name=$input_params['class_name'];
		

		if(empty($sangh_id) || empty($teacher_id) || empty($class_name) )
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_class_duplicate=$con->select_query("pathshala_class","*"," Where sangh_id='".$sangh_id."' and  class_name='".$class_name."'");
			$rowfetchduplicate = mysqli_fetch_assoc($query_class_duplicate);
			if(mysqli_num_rows($query_class_duplicate) > 0)
			{
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'Class name are already exists.'));
				
			}
			else
			{
				$x=1;
				$ClassDetail = array(

									"sangh_id"=>$sangh_id,

									"class_name"=>$class_name,
									
									"class_status"=>$x,

									"teacher_id"=>$teacher_id

								);
					$insertUser = $con->insert_record("pathshala_class",$ClassDetail);

					// $user_id = mysqli_insert_id();

					//print_r($userid);die();
					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"Class added Successfully."));
			
			}	
		}

?>