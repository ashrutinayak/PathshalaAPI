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

    	
		$student_id=$input_params['student_id'];


		if(empty($student_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_atten=$con->select_query("attendance","*,count(attendance_date) as date","Where attendance.student_id='".$student_id."'");
			$query_attendance=$con->select_query("attendance","*,count(attendance_name) as p"," Where attendance.student_id='".$student_id."' and attendance_name='P'");
			if($con->total_records($query_atten) != 0 || $con->total_records($query_attendance))
			{
				$x=0;
				$AttendanceList=array();
				while($row_result = mysqli_fetch_array($query_atten))
				{
					while($row_result1 = mysqli_fetch_array($query_attendance))
					{
						$ResultList[$x]["attendance_id"]=intval($row_result['attendance_id']);
						$ResultList[$x]["total_number_of_days"]=intval($row_result['date']);
						$ResultList[$x]["persant_number_of_day"]=intval($row_result1['p']);
						 $x++;
					}
				}
					header('Content-type: application/json');
					echo json_encode(array("status"=>1,"attendancedetail"=>$ResultList,"message"=>"Student Attendance Listed Successfully."));
				}
				else
				{
					header('Content-type: application/json');
              		echo json_encode(array("status"=>0,"message"=>"Studet Attendance are not Available!!!"));
				}

	}
?>
