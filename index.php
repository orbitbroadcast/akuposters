<?php
include('obt/inc/database.php');
include('obt/inc/functions.php');

$bgimage='bg.jpg';
if(isset($_GET['t'])){
	$form_token=$_GET['t'];
	$eventdata=get_eventdata("form_token='$form_token'");
	$bgimage=$eventdata[0]['eventbgimage'];
}
$msg='';
if(isset($_POST['btn_login'])){
	extract($_POST);
	 $qry="select u.*,p.firstname,p.lastname,p.email,r.role from tbl_users u 
		  inner join tbl_profile p on p.userid=u.userid
		  inner join tbl_roles r on r.roleid=u.roleid
		  where u.status=1 and username='$txt_username' /*and password='$txt_password'*/";
	$result = mysqli_query($conn, $qry);

	if (mysqli_num_rows($result) > 0) {
	// output data of each row
		while($row = mysqli_fetch_assoc($result)) {                
			if($row["username"]==$txt_username /*&& $row["password"]==$txt_password*/){

				$_SESSION['userdata']=array('userid'=>$row["userid"],
											'username'=>$row["username"],
											'eventid'=>$row["eventid"],
											'firstname'=>$row["firstname"],
											'lastname'=>$row["lastname"],
											'email'=>$row["email"],
											'_a'=>$row["password"],
											'role'=>$row["role"],
											'roleid'=>$row["roleid"],
											'creationdate'=>$row["creationdate"]);

				$eventid=$row["eventid"];
				$_SESSION['eventdata']=get_eventdata("id='$eventid'");
				$event_on_off=$_SESSION['eventdata'][0]['onoff'];
				
				$event_msg='';

				if($row["roleid"]!=1 && $row["roleid"]!=2){
				$event_dates=get_event_dates("eventid=$eventid");
				
				 //$date_raw=date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
                 $date_raw=date('Y-m-d');
                 $to=$event_dates[0]['edate'];
                 $from=$event_dates[2]['edate'];
                //echo "server date:".$date_raw;
                //echo "from:$from | to:$to" ;
                //echo "<hr>";
                //if(($date_raw >$from && $date_raw <=$to) || true)
                if($event_on_off=="1")
                {
                    $qry="insert into tbl_loggedin_user (userid) values(".$row["userid"].")";

            			if ($conn->query($qry) === TRUE) {
            			
            			} else {
            			
            			} 
                    header("location:obt/index.php");
                }else{
                    $event_msg= "Dear Customer your event is not started.";
                }
                

				/*for($i=0;$i<sizeof($event_dates);$i++){
					$event_date=$event_dates[$i];
					
					$date_raw=	$event_date['edate'];
					$date_= date('Y-m-d', strtotime('-1 day', strtotime($date_raw)));
					if(date('Y-m-d')<$date_){
						//$event_msg= "Dear Customer your event is not started.";
					}
				
				}
				
				for($i=0;$i<sizeof($event_dates)-1;$i++){
					$event_date=$event_dates[$i];
					if(date('Y-m-d')>$date_){
						$event_msg="Dear Customer event has been expired.";
						//return;
					}
				}*/
				}
			$qry="insert into tbl_loggedin_user (userid) values(".$row["userid"].")";

			if ($conn->query($qry) === TRUE) {
			
			} else {
			
			} 

				if(strlen($event_msg)>0){
					$msg=$event_msg;
					session_destroy();
				}else{
					header("location:obt/index.php");
				}
			}
			else
			{
				$msg="Invalid Username/Password";        
			}                
		}
	} else {
		$msg="Invalid Username/Password";
	}

	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-WR50HQ2TFL"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-WR50HQ2TFL');
</script>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>ORBIT - Virtual Confrence</title>
<meta content="" name="descriptison">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="assets/img/favicon.png" rel="icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="css.css" rel="stylesheet">
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
body {
	background: url('<?=$bgimage?>') !important;
}
</style>
</head>
<body>
<div class="container-login">
  <div class="login-page">
    <div class="form">
      <h2>Member Login</h2>
      <form class="login-form" method="POST" action="index.php?t=<?=$_GET['t']?>">
        <div style="display:none" class="info">Info message</div>
        <div style="display:none" class="success">Successful operation message</div>
        <div style="display:none" class="warning">Warning message</div>
        <div style="display:none" class="error">Error message</div>
        <div style="display:none" class="validation">Validation message</div>
        <input type="text" placeholder="Login Email" name="txt_username"/>
        <!--<input type="password" placeholder="password" name="txt_password"/>-->
        <button type="submit" name="btn_login">login</button>
        <p class="message">Not registered? <a href="register.php?t=<?=$_GET['t']?>">Create an account</a></p>
        <br>
        <br>
        <!--
        <img src="kopaq.png" style="width: 70px;margin-right: 18px;"><img src="himmel.png" style="width: 87px;"><br><br>
        -->
        <a href="https://orbitbroadcast.com" target="_blank" class="copyright">Powered by OBTech.</a>
      </form>
    </div>
  </div>
  <!-- form -->
  
  <div class="button"> </div>
  <!-- button --> 
  
  <!-- content --> 
  
</div>
<!-- container -->
<!--
<div id="footer">
  <marquee attribute_name = "attribute_value">
  <?php
	$eventid=$eventdata[0]['id'];

	$logos=get_sponsor_logo("eventid='$eventid'");
	for($i=0;$i<sizeof($logos);$i++){
		$logo=$logos[$i];
?>
  <p><a href=""><img src="<?=$logo['imageurl']?>" height="50"></a></p>
  <?php

	}
?>
  </marquee>
</div>
-->
<script>
	var _msg="<?=$msg?>";
	if(_msg.trim().length>0){
		err_msg(_msg);
	}
	function err_msg(msg){
      // $.jAlert({ //this is the normal usage
      //   'title': 'Message',
      //   'content': msg,
      //   'theme': 'red',
      //   'size': 'sm'
      // });            
      $('.info').hide();
      $('.success').hide();
      $('.warning').hide();
      $('.error').hide();
      $('.validation').hide();
	    
      $('.error').html(msg);
      $('.error').fadeIn();
      $('#btnsub').removeClass('loader');
    }

    function succ_msg(msg){
      // $.jAlert({ //this is the normal usage
      //   'title': 'Message',
      //   'content': msg,
      //   'theme': 'green',
      //   'size': 'xsm'
      // });
      $('.info').hide();
      $('.success').hide();
      $('.warning').hide();
      $('.error').hide();
      $('.validation').hide();
	    
      $('.success').html(msg);
      $('.success').fadeIn();
      $('#btnsub').removeClass('loader');
    }
    
    function validation_msg(msg){
      // $.jAlert({ //this is the normal usage
      //   'title': 'Message',
      //   'content': msg,
      //   'theme': 'green',
      //   'size': 'xsm'
      // });
      $('.info').hide();
      $('.success').hide();
      $('.warning').hide();
      $('.error').hide();
      $('.validation').hide();
	    
      $('.validation').html(msg);
      $('.validation').fadeIn();
      $('#btnsub').removeClass('loader');
    }
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5fb71853920fc91564c8cafc/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html>