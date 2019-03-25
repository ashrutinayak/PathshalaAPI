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

		$sangh_id = $input_params['sangh_id'];

    	$ex_studnet_fname = $input_params['ex_studnet_fname'];

		$ex_student_mname=$input_params['ex_student_mname'];

		$ex_student_lname=$input_params['ex_student_lname'];

		$ex_student_email=$input_params['ex_student_email'];

		$ex_student_mobile=$input_params['ex_student_mobile'];

		$ex_student_address=$input_params['ex_student_address'];
		
		$ex_student_dob=$input_params['ex_student_dob'];
		
		$ex_student_std=$input_params['ex_student_std'];
		
		$class_id=$input_params['class_id'];
		

		if(empty($ex_studnet_fname) || empty($ex_student_mname) || empty($ex_student_lname) || empty($ex_student_email) || empty($ex_student_mobile) || empty($ex_student_dob)|| empty($ex_student_std))
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			$query_student_duplicate=$con->select_query("external_student","*"," Where ex_student_mobile='".$ex_student_mobile."'");
			$rowfetchduplicate = mysqli_fetch_assoc($query_student_duplicate);
			if(mysqli_num_rows($query_student_duplicate) > 0)
			{
				header('Content-type: application/json');
				echo json_encode(array('status'=>0,'message'=>'Mobile number already exists.'));
				
			}
			else
			{
				$x=1;
				$StudentDetail = array(

									"sangh_id"=>$sangh_id,

									"ex_studnet_fname"=>$ex_studnet_fname,

									"ex_student_mname"=>$ex_student_mname,

									"ex_student_lname"=>$ex_student_lname,

									"ex_student_email"=>$ex_student_email,
									
									"ex_student_mobile"=>$ex_student_mobile,

									"ex_student_address"=>$ex_student_address,

									"ex_student_dob"=>$ex_student_dob,

									"ex_status"=>$x,
									
									"class_id"=>$class_id,
									
									"ex_student_std"=>$ex_student_std

								);
					$insertUser = $con->insert_record("external_student",$StudentDetail);
					
					$student_id = $con->last_inserted_id($insertUser);

					$modlefetch = $con->select_query("syallbus_new","*","where sangh_id='".$sangh_id."'","");

					if (!empty($modlefetch))
					{
						$modeldata=array();
						$x=0;
						while ($row=mysqli_fetch_array($modlefetch)) 
						{
								// $modeldata[$x]['module_id']=$row['id'];
								$modeldata[$x]['module_name']=$row['module_name'];
								$modeldata[$x]['sangh_id']=$row['sangh_id'];
								$modeldata[$x]['module_detail']=$row['module_details'];
								$x++;
						}
						$p=0;
						foreach ($modeldata as $row1) 
						{
							$module=array(
								"student_id"=>$student_id,
								// "module_s_id"=>$row1['module_id'],
								"class_id"=>$class_id,
								"sangh_id"=>$row1['sangh_id'],
								"module_name"=>$row1['module_name'],
								"module_details"=>$row1['module_detail'],
								"module_status"=>$p
						);
							$insertmodul = $con->insert_record("module_add",$module);
						}
					}
					header('Content-type: application/json');

					echo json_encode(array("status"=>1,"message"=>"Student are add Successfully."));
			
			}	
		}

?>