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

    	
		$teacher_mobile=$input_params['teacher_mobile'];

		$teacher_password=$input_params['teacher_password'];
		

		if(empty($teacher_mobile) || empty($teacher_password))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_teacher_login=$con->select_query("teacher","*","INNER JOIN `sangh_directory` ON `sangh_directory`.`sangh_id`=`teacher`.`sangh_id` Where `teacher`.`teacher_mobile`='".$teacher_mobile."'");
			$row_teacher=mysqli_fetch_array($query_teacher_login);
			if(!empty($row_teacher))
			{
				if($row_teacher['teacher_status']==1)
				{
					if($row_teacher['teacher_password'] == $teacher_password)
					{
						$TeacherList["teacher_id"]=intval($row_teacher['teacher_id']);
						$TeacherList["firstname"]=$row_teacher['teacher_fname'];
						$TeacherList["middlename"]=$row_teacher['teacher_mname'];
						$TeacherList["lastname"]=$row_teacher['teacher_lname'];
						$TeacherList["mobile"]=$row_teacher['teacher_mobile'];
						$TeacherList["email"]=$row_teacher['teacher_email'];
						$TeacherList["address"]=$row_teacher['teacher_address'];
						$TeacherList["sangh_name"]=$row_teacher['sangh_name'];
						$TeacherList["sangh_id"]=$row_teacher['sangh_id'];
						// $x++;
					header('Content-type: application/json');
					echo json_encode(array("status"=>1,"teacherDetail"=>$TeacherList,"message"=>"You are Login Successfully."));
					}	
					else
					{
						header('Content-type: application/json');
						echo json_encode(array("status"=>0,"message"=>"Mobile Number Or Password are Invalid."));

					}
				}
				else
				{
					header('Content-type: application/json');
              		echo json_encode(array("status"=>0,"message"=>"Teacher are not Approve By Admin!!!"));
				}
			}
			else
			{
				header('Content-type: application/json');
				echo json_encode(array("status"=>0,"message"=>"You are not Register."));

			}
	}
?>