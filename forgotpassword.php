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

      
    $teacher_mobile=$input_params['teacher_mobile'];
   
    $teacher_email=$input_params['teacher_email'];
    


      $query_teacher_detail=$con->select_query("teacher","*","INNER JOIN sangh_directory ON sangh_directory.sangh_id=teacher.sangh_id INNER JOIN pathshala on pathshala.sangh_id =teacher.sangh_id where teacher_mobile='".$teacher_mobile."' OR teacher_email='".$teacher_email."'","","");  
      $row=mysqli_fetch_assoc($query_teacher_detail);
      if($con->total_records($query_teacher_detail)>0)
      {
        if($row['teacher_email']!='' || $row['teacher_mobile']!=='')
        {

            $headers .= "MIME-Version: 1.0\r\n";
                      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "From: info@jainsangh.in(JainSangh)\r\n";
                       // $headers .= "ashruti.vnurture.in";
                      $message="<div style=font-family:Roboto,RobotoDraft,Helvetica,Arial,sans-serif><table width=800 rules=all border=1 style=border-color:#666 cellpadding=10><tbody><tr style=background:lightblue><td colspan=2><div style=float:left;border-color:#666><img src=http://jainsangh.info/images/Jain%20Sangh%20Pathshala%20logo_512.png style=border-radius:5px;width:160px alt=jainsangh tabindex=0></div><div><h3 style=color:red;text-align:center;font-weight:bold;font-size:21px>".$row['pathshala_name']."</h3><h3 style=color:red;text-align:center;font-weight:bold;font-size:21px>".$row['sangh_name']."</h3><p style=font-weight:bold;text-align:center>".$row['address']." ".$row['landmark']." ".$row['pincode']." ".$row['city_name']." ".$row['state_name']."</p><p style=font-weight:bold;text-align:center>Phone:<label>".$row['mobile_code']." ".$row['mobile']."</label>,  Email: <label style=color:#5483d7><a href='mailto:info@jainsangh.in' target=_blank>info@jainsangh.in</a></label></p></div> </td></tr><tr style=background:#f9f1f1><td colspan=2>
              <div style=border-color:#666;font-size:14px><tr style=background:#ff8c5a><td colspan=2><p style=text-align:center;font-weight:bold;color:blue>Your Account Detail</p></td></tr><tr style=background:#eee><td width=150 style=background:#dbf1f9>Teachername:</td><td style=background:#eee>".$row["teacher_fname"]." ".$row["teacher_mname"]." ".$row["teacher_lname"]."</td></tr><tr style=background:#eee><td style=background:#dbf1f9>Email ID:</td><td style=background:#eee>".$row["teacher_email"]."</td></tr><tr><td width=150 style=background:#dbf1f9>Your Password:</td><td style=background:#eee>".$row["teacher_password"]."</td></tr><tr><td width=150 style=background:#dbf1f9>Your Login Id:</td><td style=background:#eee>".$row['teacher_mobile']."</td></tr><tr style=color:#CCCCCC;line-height:120%;font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;><td colspan=2> 
    <a href=http://jainsangh.in style=text-decoration: none; color: #fff; float: left;>Jainsangh.in</a>
        <a href=https://play.google.com/store/apps/details?id=com.jainsangh.admin.jainsangh style=display:inline-block;margin-left:100px target=_blank><img src=http://jainsangh.in/images/play.png width=120></a>  
    <a href=http://jainsangh.info style=text-decoration: none; color: #fff; float: right; padding-right:50px;>jainsangh.info</a>      
 </td> </tr></tbody></table><br><p>Truly Yours</p><p>Jain Sangh</p></div>";
                mail($row['teacher_email'],"Pathshala Teacher Forgot Password !!!",$message,$headers);
                      //For SMS
                          $ch = curl_init();
                      curl_setopt_array($ch, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL =>"http://1.rapidsms.co.in/api/push.json?apikey=5c0795850512a&route=clientsms&sender=JAINSG&mobileno=+91".$teacher_mobile."&text=Dear Pathshala Teacher, your Password is : ".$row['teacher_password']."%0a%0aThank You %0aPlease visit,%0awww.jainsangh.in",
                        CURLOPT_USERAGENT => 'message sent successfully'
                      ));
                    //curl_setopt($ch, CURLOPT_HEADER, 0);
                      $resp=curl_exec($ch);
                
                    // close cURL resource, and fr
                    // grab URL and pass it toee up system resources
                      curl_close($ch);
                  }
          header('Content-type: application/json');
            echo json_encode(array('status'=>1,'message'=>'Your password has been sent to your registered Email-id Or Mobile Number.')); 
          }
        else
        {
           header('Content-type: application/json'); 
          echo json_encode(array("status"=>0,"message"=>"Email Or Mobile No does not exit."));
        }
  

?>