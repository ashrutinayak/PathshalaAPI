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
		

			$condition .="sangh_directory.sangh_name like '$searchsangh%'";

			$DirectoryDetailsQuery=$con->select_query("sangh_directory","*","inner join city on city.city_id=sangh_directory.city inner join
			country ON country.country_id=sangh_directory.country
			inner join state ON state.state_id=sangh_directory.state where $condition");
			if($con->total_records($DirectoryDetailsQuery) != 0)
			{
				$x=0;
				$DirectoryList=array();
				while($row_dir = mysqli_fetch_array($DirectoryDetailsQuery))
				{
					$DirectoryList[$x]["sangh_id"]=intval($row_dir['sangh_id']);
					$DirectoryList[$x]["sangh_name"]=$row_dir['sangh_name'];
					$DirectoryList[$x]["address"]=$row_dir['address'];
					$DirectoryList[$x]["landmark"]=$row_dir['landmark'];
				    $DirectoryList[$x]["city_name"]=$row_dir['city_name'];
					$DirectoryList[$x]["pincode"]=$row_dir['pincode'];
					// $DirectoryList[$x]["district_name"]=$row_dir['district_name'];
					$DirectoryList[$x]["state_name"]=$row_dir['state_name'];
					$DirectoryList[$x]["country_name"]=$row_dir['country_name'];
					$DirectoryList[$x]["telephone"]=$row_dir['telephone'];
					$DirectoryList[$x]["mobile_code"]=$row_dir['mobile_code'];
					$DirectoryList[$x]["mobile"]=$row_dir['mobile'];
					$DirectoryList[$x]["email"]=$row_dir['email'];
					$DirectoryList[$x]["website"]=$row_dir['website'];
					
					$x++;
				}
				header('Content-type: application/json');
				echo json_encode(array("status"=>1,"directoryDetails"=>$DirectoryList,"message"=>"Directory Details Listed Successfully")); 
			}
			else
			{
				header('Content-type: application/json');
				echo json_encode(array("status"=>0,"message"=>"No available"));
			}
		
?>