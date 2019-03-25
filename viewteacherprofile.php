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


		if(empty($teacher_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_teacher=$con->select_query("teacher","*","INNER JOIN `sangh_directory` ON `sangh_directory`.`sangh_id`=`teacher`.`sangh_id` Where `teacher`.`teacher_id`='".$teacher_id."'");
			if($con->total_records($query_teacher) != 0)
			{
				$x=0;
				$TeacherList=array();
				while($row_teacher = mysqli_fetch_array($query_teacher))
				{

					if($row_teacher['teacher_status']==1)
					{
						$TeacherList["teacher_id"]=intval($row_teacher['teacher_id']);
						$TeacherList["firstName"]=$row_teacher['teacher_fname'];
						$TeacherList["middleName"]=$row_teacher['teacher_mname'];
						$TeacherList["lastName"]=$row_teacher['teacher_lname'];
						$TeacherList["mobile"]=$row_teacher['teacher_mobile'];
						$TeacherList["email"]=$row_teacher['teacher_email'];
						$TeacherList["address"]=$row_teacher['teacher_address'];
						$TeacherList["sangh_name"]=$row_teacher['sangh_name'];
						 // $x++;
						}
					}
					header('Content-type: application/json');
					echo json_encode(array("status"=>1,"teacher_id"=>$TeacherList['teacher_id'],"firstName"=>$TeacherList['firstName'],"middleName"=>$TeacherList['middleName'],"lastName"=>$TeacherList['lastName'],"mobile"=>$TeacherList['mobile'],"email"=>$TeacherList['email'],"address"=>$TeacherList['address'],"sangh_name"=>$TeacherList['sangh_name'],"message"=>"Teacher Listed Successfully."));
				}
				else
				{
					header('Content-type: application/json');
              		echo json_encode(array("status"=>0,"message"=>"Teacher are not Available!!!"));
				}

	}
?>
