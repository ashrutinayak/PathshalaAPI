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
			$query_class=$con->select_query("pathshala_class","*","INNER JOIN `sangh_directory` ON `sangh_directory`.`sangh_id`=`pathshala_class`.`sangh_id` INNER JOIN `teacher` ON `teacher`.teacher_id=pathshala_class.teacher_id Where `pathshala_class`.`sangh_id`='".$sangh_id."' and `pathshala_class`.`class_status`=1");
			if($con->total_records($query_class) != 0)
			{
				$x=0;
				$ClassList=array();
				while($row_class = mysqli_fetch_array($query_class))
				{
						$ClassList[$x]["class_id"]=intval($row_class['class_id']);
						$ClassList[$x]["teacher_name"]=$row_class['teacher_fname']." ".$row_class['teacher_mname']." ".$row_class['teacher_lname'];
						$ClassList[$x]["sangh_name"]=$row_class['sangh_name'];
						$ClassList[$x]["class_name"]=$row_class['class_name'];
						 $x++;
					}
					header('Content-type: application/json');
					echo json_encode(array("status"=>1,"classdetail"=>$ClassList,"message"=>"Class Listed Successfully."));
				}
				else
				{
					header('Content-type: application/json');
              		echo json_encode(array("status"=>0,"message"=>"Class are not Available!!!"));
				}

	}
?>
