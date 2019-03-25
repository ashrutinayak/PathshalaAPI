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



    	$teacher_fname = $input_params['teacher_fname'];

		$teacher_mname=$input_params['teacher_mname'];

		$teacher_lname=$input_params['teacher_lname'];

		$teacher_mobile=$input_params['teacher_mobile'];

		$teacher_email=$input_params['teacher_email'];

		$teacher_address=$input_params['teacher_address'];
		
		$teacher_password=$input_params['teacher_password'];
		
		$sangh_id=$input_params['sangh_id'];
		

		if(empty($sangh_id) || empty($teacher_fname) || empty($teacher_mname) || empty($teacher_lname) || empty($teacher_mobile) || empty($teacher_email)|| empty($teacher_address))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_teacher_duplicate=$con->select_query("teacher","*"," Where teacher_mobile='".$teacher_mobile."'","");
			$rowfetchduplicate = mysqli_fetch_assoc($query_teacher_duplicate);
			if(mysqli_num_rows($query_teacher_duplicate) > 0)
			{
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'Mobile number already exists.'));
				
			}
			else
			{
				$x=0;
				$TeacherDetail = array(

									"sangh_id"=>$sangh_id,

									"teacher_fname"=>$teacher_fname,

									"teacher_mname"=>$teacher_mname,

									"teacher_lname"=>$teacher_lname,
									
									"teacher_mobile"=>$teacher_mobile,

									"teacher_email"=>$teacher_email,

									"teacher_password"=>$teacher_password,
									
									"teacher_address"=>$teacher_address,
									"teacher_status"=>$x

								);
					$insertUser = $con->insert_record("teacher",$TeacherDetail);

					// $user_id = mysqli_insert_id();

					//print_r($userid);die();
					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"You are Successfully Register."));
			
			}	
		}

?>