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
			$query_class=$con->select_query("external_student","*"," INNER JOIN pathshala_class ON pathshala_class.class_id=external_student.class_id Where external_student.class_id='".$class_id."' and external_student.ex_status=1");
			if($con->total_records($query_class) != 0)
			{
				$x=0;
				$ClassList=array();
				while($row_class = mysqli_fetch_array($query_class))
				{
						$ClassList[$x]["ex_student_id"]=intval($row_class['ex_student_id']);
						$ClassList[$x]["ex_studnet_name"]=$row_class['ex_studnet_fname']." ".$row_class['ex_student_mname']." ".$row_class['ex_student_lname'];
						$ClassList[$x]["ex_student_email"]=$row_class['ex_student_email'];
						$ClassList[$x]["ex_student_mobile"]=$row_class['ex_student_mobile'];
						$ClassList[$x]["ex_student_address"]=$row_class['ex_student_address'];
						$ClassList[$x]["ex_student_dob"]=$row_class['ex_student_dob'];
						$ClassList[$x]["ex_student_std"]=$row_class['ex_student_std'];
						$ClassList[$x]["class_name"]=$row_class['class_name'];
						 $x++;
					}
					header('Content-type: application/json');
					echo json_encode(array("status"=>1,"studentdetail"=>$ClassList,"message"=>"Students Listed Successfully."));
				}
				else
				{
					header('Content-type: application/json');
              		echo json_encode(array("status"=>0,"message"=>"Studets are not Available!!!"));
				}

	}
?>
