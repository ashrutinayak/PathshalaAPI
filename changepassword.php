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

    	
		$teacher_id=$input_params['teacher_id'];

		$teacher_password=$input_params['teacher_password'];
		
		$teacher_newpassword=$input_params['teacher_newpassword'];
		

		if(empty($teacher_id) || empty($teacher_password) || empty($teacher_newpassword))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_teacher_changepassword=$con->select_query("teacher","teacher_password","Where teacher_id='".$teacher_id."'");
			$row_teacher=mysqli_fetch_array($query_teacher_changepassword);
			if(!empty($row_teacher))
			{
				
					if($row_teacher['teacher_password'] != $teacher_password)
					{
						
						header('Content-type: application/json');
              			echo json_encode(array("status"=>0,"message"=>"Invalid Current Password."));
					}	
					else
					{
						$teacher_newpassword = array('teacher_password'=>$teacher_newpassword);
				        $query = $con->update("teacher",$teacher_newpassword,"where teacher_id='".$teacher_id."'");
          header('Content-type: application/json');
          echo json_encode(array("status"=>1,"message"=>"Change Password Successfully."));

					}
			}

	}
?>