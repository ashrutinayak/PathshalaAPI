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

		
		$ex_student_id=$input_params['ex_student_id'];
		
		if(empty($ex_student_id))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_student_update=$con->select_query("external_student","*"," Where ex_student_id='".$ex_student_id."'");
			$studentdetail = mysqli_fetch_assoc($query_student_update);
			if(empty($studentdetail))
			{
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'Student  are not available.'));
				
			}
			else
			{
				if ($studentdetail['ex_status']==1)
				{
					$y=0;
					$studnetstatus = array(
							"ex_status"=>$y
					);
					$updatestudent = $con->update("external_student",$studnetstatus,"where ex_student_id='".$ex_student_id."'");

					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"Student deactive Successfully."));

				}
				else
				{
					$x=1;
					$studnetstatus = array(
							"ex_status"=>$x
					);
					$updateclass = $con->update("external_student",$studnetstatus,"where ex_student_id='".$ex_student_id."'");

					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"Student active Successfully."));
			}
			}	
		}

?>