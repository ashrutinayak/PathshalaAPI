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

    	
		$sangh_id=$input_params['sangh_id'];


		if(empty($sangh_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_teacher=$con->select_query("teacher","*","INNER JOIN `sangh_directory` ON `sangh_directory`.`sangh_id`=`teacher`.`sangh_id` Where `teacher`.`sangh_id`='".$sangh_id."'");
			if($con->total_records($query_teacher) != 0)
			{
				$x=0;
				$TeacherList=array();
				while($row_teacher = mysqli_fetch_array($query_teacher))
				{

					if($row_teacher['teacher_status']==1)
					{
						$TeacherList[$x]["teacher_id"]=intval($row_teacher['teacher_id']);
						$TeacherList[$x]["firstName"]=$row_teacher['teacher_fname'];
						$TeacherList[$x]["middleName"]=$row_teacher['teacher_mname'];
						$TeacherList[$x]["lastName"]=$row_teacher['teacher_lname'];
						$TeacherList[$x]["mobile"]=$row_teacher['teacher_mobile'];
						$TeacherList[$x]["email"]=$row_teacher['teacher_email'];
						$TeacherList[$x]["address"]=$row_teacher['teacher_address'];
						$TeacherList[$x]["sangh_name"]=$row_teacher['sangh_name'];
						 $x++;
						}
					}
					header('Content-type: application/json');
					echo json_encode(array("status"=>1,"teacherdetail"=>$TeacherList,"message"=>"Teacher Listed Successfully."));
				}
				else
				{
					header('Content-type: application/json');
              		echo json_encode(array("status"=>0,"message"=>"Teacher are not Available!!!"));
				}

	}
?>
