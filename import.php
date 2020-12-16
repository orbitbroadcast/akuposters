<?php

include('obt/inc/database.php');
include('obt/inc/functions.php');

$id='1605166637-597312665';
if(!isset($_GET['password']) && $_GET['password']!=2512)
{
    echo "Please enter password";
    die();
}
echo "Starting Import<br>";
echo "<hr>";

$datanew=select("SELECT * from registration2 where email in (SELECT username FROM tbl_users WHERE username in (select email from registration2))");
//print_r($datanew);die();
//print_r($data);
$data_=array();
$res='';
for($i=0;$i<sizeof($datanew);$i++){

   
    $aname=$datanew[$i]['aname'];
    $institute=$datanew[$i]['institute'];
    $designation=$datanew[$i]['designation'];
    $city=$datanew[$i]['city'];
    $country="";//$datanew[$i]['country']
    $mobileno=$datanew[$i]['mobileno'];

    $email=$datanew[$i]['email'];
    $orbit_username=$email;
    $pass=explode('@',$email);
    $orbit_password=$pass[0].'.orbit';

    echo $res="Name=$aname|designation=$designation|Institute=$institute|pmdc=|city=$city|country=$country|contact_no=$mobileno|orbit_username=$email|orbit_password=$orbit_password|~";
    echo '<hr>';
    //reg_user($data,$_username,$_password,$id,$uid,$profile_pic)
    sendmail3($orbit_username);
}
sendmail3("zohaib@fzdubai.com");
sendmail3("ovais@orbitadv.com");
function sendmail3($_username)
{
  $_name='Attendee';
  $to=$_username;
  //$_password;
  $msg="Dear $_name,<br><br>";
  $msg.="Your login details for <b>36th RSP Annual virtual meeting 2020.</b> are as below<br><br>";
  $msg.="Kindly Login using your email ID<br>";
  $msg.="Your registered email ID is: ".trim($to)."<br><br>";
 // $msg.="Password: $_password<br><br>";
 // $msg.="This link will be activated from 21st Nov 2020.<br>";
  $msg.="".htmlentities("https://rspvirtualmeet.com")."<br><br>";
  $msg.="Please see the attached <a href=".htmlentities("https://youtu.be/FFGPQjSQeqY").">video tutorial</a> to navigate the meeting.<br><br>";
  $msg.="Kindly find attached the program details.<br>";
  $msg.="<a href=".htmlentities("http://rspvirtualmeet.com/scientific-program.pdf").">Scientific Program</a>, <a href=".htmlentities("http://rspvirtualmeet.com/abstract-scientific%20-program.pdf").">Free papers</a>, & <a href=".htmlentities("http://rspvirtualmeet.com/tech-scientific%20-program.pdf").">Technologist Corner</a><br><br>";
  $msg.="For queries: <a href=".htmlentities("mailto:info@rspvirtualmeet.com").">info@rspvirtualmeet.com</a><br><br>";
  $msg.="Date: Nov 21st-22nd, 2020 Lahore, Pakistan.<br><br>";
  $msg.="<b>System Requirement</b><br><br>";
  $msg.="Note: Windows 7 and higher / Mac OSX 10.8 or Linux/Ubuntu<br>";
  $msg.="Latest Chrome Web Browser or the newest Edge browser<br>";
  $msg.="Broadband internet connection with an Upload and Download speed of 1 Mbps or more.<br>";
  $msg.="IOS & Android Not Supported<br><br>";
  $msg.="Regards,<br>";
  $msg.="Radiological Society of Pakistan<br>";
  $msg.="<a href=".htmlentities("https://www.facebook.com/36thVirtualMeeting/").">https://www.facebook.com/36thVirtualMeeting</a><br/><br>";
  $msg.="<img src=".htmlentities("https://rspvirtualmeet.com/uploads/sponsors/login-rsp.jpg").">";

  $msg=htmlentities($msg);
  $msg=html_entity_decode($msg);
  $fromName='Radiological Society of Pakistan';
  $from='info@rspvirtualmeet.com';

  // Set content-type header for sending HTML email 
  $headers = "MIME-Version: 1.0" . "\r\n"; 
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

  // Additional headers 
  $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
  $headers .= 'Cc: ' . "\r\n"; 
  $headers .= 'Bcc: ' . "\r\n"; 
echo $msg;
  @mail($to,"36th Annual Virtual Meeting 2020.",$msg,$headers);
}
function sendmail2($_username,$_name)
{

  //$_name='Attendee';
  $to=$_username;
  //$_password;
  $msg="Dear $_name,<br><br>";
  $msg.="You are Cordially invited to general body meeting of RADIOLOGICAL SOCIETY OF PAKISTAN at 8:30 pm";
  $msg.="<br><br>Join URL: <a href=".htmlentities("https://rspvirtualmeet.com").">https://rspvirtualmeet.com</a><br>";
  $msg.="Login with your Email:$to<br>";
  
  $msg=htmlentities($msg);
  $msg=html_entity_decode($msg);
  $fromName='Radiological Society of Pakistan';
  $from='info@rspvirtualmeet.com';

  // Set content-type header for sending HTML email 
  $headers = "MIME-Version: 1.0" . "\r\n"; 
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

  // Additional headers 
  $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
  $headers .= 'Cc: ' . "\r\n"; 
  $headers .= 'Bcc: ' . "\r\n"; 

  echo $msg;
  @mail($to,"General body meeting 2020",$msg,$headers);
}
$res= str_replace("?",'',$res);;


function reg_user($data,$_username,$_password,$id,$uid,$profile_pic){
    global $conn;
    $formid=get_new_formid();
    $res=1;
    $_name='';
    for($i=0;$i<sizeof($data)-1;$i++)
    {    
      $val=explode('=',$data[$i]);
      $qry="insert into tbl_register (form_token,fieldname,fieldvalue,userid,formid) values('$id','$val[0]','$val[1]',$uid,$formid)";
      if($val[0]=='Name'){       
        $_name=$val[1];      
      }
      if ($conn->query($qry) === TRUE){     
      }else{
        echo "Error: " . $qry . "|" . $conn->error;
        //die();
      } 
    }
    if(strlen($profile_pic)>0){
      $qry="insert into tbl_register (form_token,fieldname,fieldvalue,userid,formid) values('$id','profile_pic','$profile_pic',$uid,$formid)";
      if ($conn->query($qry) === TRUE){     
      }else{
        echo "Error: " . $qry . "|" . $conn->error;
        //die();
      } 
    }
    
    $_name='Attendee';
  $to=$_username;
  //$_password;
  $msg="Dear $_name,<br><br>";
  $msg.="You are now registered for <b>36th RSP Annual virtual meeting 2020.</b>.<br><br>";
  $msg.="Your details are below<br>";
  $msg.="login ID: $to<br>";
  $msg.="Password: $_password<br><br>";
  $msg.="This link will be activated from 21st Nov 2020.<br>";
  $msg.="https://event.rspvirtualmeet.com<br><br>";
  $msg.="Please see the attached <a href=".htmlentities("https://youtu.be/FFGPQjSQeqY").">video tutorial</a> to navigate the meeting.<br><br>";
  $msg.="Kindly find attached the program details.<br>";
  $msg.="<a href=".htmlentities("http://rspvirtualmeet.com/scientific-program.pdf").">Scientific Program</a>, <a href=".htmlentities("http://rspvirtualmeet.com/abstract-scientific%20-program.pdf").">Free papers</a>, & <a href=".htmlentities("http://rspvirtualmeet.com/tech-scientific%20-program.pdf").">Technologist Corner</a><br><br>";
  $msg.="For queries: <a href=".htmlentities("mailto:info@rspvirtualmeet.com").">info@rspvirtualmeet.com</a><br><br>";
  $msg.="Date: Nov 21st-22nd, 2020 Lahore, Pakistan.<br><br>";
  $msg.="<b>System Requirement</b><br><br>";
  $msg.="Note: Windows 7 and higher / Mac OSX 10.8 or Linux/Ubuntu<br>";
  $msg.="Latest Chrome Web Browser or the newest Edge browser<br>";
  $msg.="Broadband internet connection with an Upload and Download speed of 1 Mbps or more.<br>";
  $msg.="IOS & Android Not Supported<br><br>";
  $msg.="Regards,<br>";
  $msg.="Radiological Society of Pakistan<br>";
  $msg.="<a href=".htmlentities("https://www.facebook.com/36thVirtualMeeting/").">https://www.facebook.com/36thVirtualMeeting</a><br/><br>";
  $msg.="<img src=".htmlentities("https://rspvirtualmeet.com/uploads/sponsors/login-rsp.jpg").">";

  $msg=htmlentities($msg);
  $msg=html_entity_decode($msg);
  $fromName='Radiological Society of Pakistan';
  $from='info@rspvirtualmeet.com';

  // Set content-type header for sending HTML email 
  $headers = "MIME-Version: 1.0" . "\r\n"; 
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

  // Additional headers 
  $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
  $headers .= 'Cc: ' . "\r\n"; 
  $headers .= 'Bcc: ' . "\r\n"; 

  //@mail($to,"36th Annual Virtual Meeting 2020.",$msg,$headers);
  //@mail($to,"General body meeting 2020",$msg,$headers);


  $chat_password=$_password;
  $chat_email=$_username;
  $chat_user=substr($_username,0,strpos($_username,'@'));
  echo "User registered successfully, Please check your email for further details, and if you don't receive your email please check your junk email";
  echo "|".$chat_user."|".$chat_password."|".$chat_email;
  }   




  if(isset($res))
  {

    die();
    $_data=$res;

    $_dataa=explode("~",$_data);
 
    for($k=0;$k<sizeof($_dataa);$k++)
    {
        $data=explode("|",$_dataa[$k]);


        $user_exists=0;
        $t_orbit_user='';
        $t_orbit_pass='';
        for($i=0;$i<sizeof($data)-1;$i++){
          $val=explode('=',$data[$i]);
      
          if($val[0]=='orbit_username')
          {
            $username=$val[1];
            $t_orbit_user=$username;
            $qry_uc=select("select * from tbl_users where username='$username'");
            if(sizeof($qry_uc)>0)
            {
              $user_exists=1;
            }
          }
          else if($val[0]=='orbit_password')
          {
            $t_orbit_pass=$val[1];      
          }
        }
        
        if($user_exists==0)
        {
          $eventid=11;
          
          $userqry="insert into tbl_users (username,password,roleid,status,eventid) values('$t_orbit_user','$t_orbit_pass',5,1,$eventid)";
          if($conn->query($userqry) === TRUE){
              $uid=mysqli_insert_id($conn);
              $profileqry="insert into  tbl_profile (userid,firstname,status) values('$uid','$t_orbit_user',1)";
              if($conn->query($profileqry) === TRUE){
                  reg_user($data,$t_orbit_user,$t_orbit_pass,$id,$uid,"");
                  
              }
          }        
        }
        else
        {
          echo "This email address is already registered.";
        }
    }
    echo "<hr>";
    echo "Import Finished";
    
  }
?>