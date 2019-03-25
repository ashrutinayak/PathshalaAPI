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

    	$teacher_id = $input_params['teacher_id'];

		$student_id=$input_params['student_id'];
		
		$class_id=$input_params['class_id'];
		
		$attendance_name=$input_params['attendance_name'];
		
		if (empty($teacher_id) ||empty($class_id))
		{
			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));
		}
		else
		{
			$date=date('Y/m/d');
			$attquery=$con->select_query("attendance","*"," Where teacher_id='".$teacher_id."' and class_id='".$class_id."' and attendance_date='".$date."'");
			$rowfetchduplicate = mysqli_fetch_assoc($attquery);
			if(mysqli_num_rows($attquery) > 0)
			{
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'Attendance already fill.'));
				
			}
			else
			{
				$stdattendanceDetail = array(

									"attendance_date"=>$date,

									"teacher_id"=>$teacher_id,
									
									"class_id"=>$class_id,

									$attendance_name=array(
										"student_id"=>$student_id,
										"attendance_name"=>$attendance_name
									)
								);

				foreach($stdattendanceDetail as $row)
				{
					$attendance_date=$date;
					$teacher_id1=$teacher_id;
					$class_id1=$class_id;
					foreach($row['attendance_name'] as $row1)
					{
						$student_id=$row1['student_id'];
						$attendance_name=$row1['attendance_name'];
						// echo $student_id;die();
						$arruser=array(
									"attendance_date"=>$attendance_date,
									"teacher_id"=>$teacher_id1,
									"class_id"=>$class_id1,
									"student_id"=>$student_id,
									"attendance_name"=>$attendance_name
						);
						$insertattendance=$con->insert_record("attendance",$arruser);
					}
				}
				header('Content-type: application/json');

				echo json_encode(array("status"=>1,"message"=>"Attendance add Successfully."));
		}
	}		
	

?>	