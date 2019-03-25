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

    	
		$teacher_fname=$input_params['teacher_fname'];
		
		$teacher_id=$input_params['teacher_id'];

		$teacher_mname=$input_params['teacher_mname'];
		
		$teacher_lname=$input_params['teacher_lname'];
		
		$teacher_email=$input_params['teacher_email'];
		
		$teacher_address=$input_params['teacher_address'];
		

		if(empty($teacher_fname) || empty($teacher_mname)  || empty($teacher_lname) || empty($teacher_email) || empty($teacher_address))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_teacher_changedetails=$con->select_query("teacher","*","Where teacher_id='".$teacher_id."'");
			$row_teacher=mysqli_fetch_array($query_teacher_changedetails);
			if(!empty($row_teacher))
			{
						$teacher_deatail = array(
							'teacher_fname'=>$teacher_fname,
							'teacher_mname'=>$teacher_mname,
							'teacher_lname'=>$teacher_lname,
							'teacher_email'=>$teacher_email,
							'teacher_address'=>$teacher_address
						);
				        $query = $con->update("teacher",$teacher_deatail,"where teacher_id='".$teacher_id."'");
          header('Content-type: application/json');
          echo json_encode(array("status"=>1,"message"=>"Update teacher details Successfully."));

			}
			else
			{
				header('Content-type: application/json');
          		echo json_encode(array("status"=>0,"message"=>"No teacher available."));

			}

	}
?>