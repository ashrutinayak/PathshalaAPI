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

    	
		$searchsangh=$input_params['searchsangh'];
		
		$searchstudent=$input_params['searchstudent'];
		

		if(empty($searchsangh) )
		{

			header('Content-type: application/json');

			echo json_encode(array("status"=>0,"message"=>"Please fill all required Fields"));	

		}
		else
		{
			if(!empty($searchsangh))
			{
				$condition .="sangh_directory.sangh_id like '$searchsangh%'";
			}
			if (!empty($searchstudent))
			{
				$condition .=" AND add_family_member.reg_fm_fname like '%".$searchstudent."%' or add_family_member.reg_fm_mname like '$searchstudent%' or add_family_member.reg_fm_lname like '$searchstudent.'";
				
			}
			$StudentDetailsQuery=$con->select_query("add_family_member","*","inner join sangh_directory on sangh_directory.sangh_id=add_family_member.sangh_id inner join city on city.city_id=add_family_member.reg_fm_cityid inner join
				country ON country.country_id=add_family_member.reg_fm_countryid
				inner join state ON state.state_id=add_family_member.reg_fm_stateid where $condition");
			if($con->total_records($StudentDetailsQuery) != 0)
			{
				$x=0;
				$DirectoryList=array();
				while($row_dir = mysqli_fetch_array($StudentDetailsQuery))
				{
					$DirectoryList[$x]["sangh_id"]=intval($row_dir['sangh_id']);
					$DirectoryList[$x]["reg_par_id"]=intval($row_dir['reg_par_id']);
					$DirectoryList[$x]["firstname"]=$row_dir['reg_fm_fname'];
					$DirectoryList[$x]["middlename"]=$row_dir['reg_fm_mname'];
				    $DirectoryList[$x]["lastname"]=$row_dir['reg_fm_lname'];
					$DirectoryList[$x]["education"]=$row_dir['reg_fm_education'];
					$DirectoryList[$x]["email"]=$row_dir['reg_fm_email'];
					$DirectoryList[$x]["mobile_code"]=$row_dir['reg_con_mobile_code'];
					$DirectoryList[$x]["mobile"]=$row_dir['reg_fm_mobileno'];
					$DirectoryList[$x]["dob"]=$row_dir['reg_fm_dob'];
					$DirectoryList[$x]["address"]=$row_dir['reg_fm_address']." ".$row_dir['reg_fm_land']." ".$row_dir['reg_fm_pincode']." ".$row_dir['city_name']." ".$row_dir['state_name'].$row_dir['country_name'];

					$x++;
				}
				header('Content-type: application/json');
				echo json_encode(array("status"=>1,"studentDetails"=>$DirectoryList,"message"=>"Student Details Listed Successfully")); 
			}
			else
			{
				header('Content-type: application/json');
				echo json_encode(array("status"=>0,"message"=>"No available"));
			}
		}
?>