<?php
include('obt/inc/database.php');
include('obt/inc/functions.php');
$id=$_GET['t'];
$bgimage='bg.jpg';
if(isset($_GET['t'])){
	$form_token=$_GET['t'];
	$eventdata=get_eventdata("form_token='$form_token'");
	$bgimage=$eventdata[0]['eventbgimage'];

	//$bgimage=(str_len($bgimage)>0)?$bgimage:'bg.jpg';
}
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
      echo "Error: " . $qry . "|" . $conn->error;die();
    } 
  }
  if(strlen($profile_pic)>0){
    $qry="insert into tbl_register (form_token,fieldname,fieldvalue,userid,formid) values('$id','profile_pic','$profile_pic',$uid,$formid)";
    if ($conn->query($qry) === TRUE){     
    }else{
      echo "Error: " . $qry . "|" . $conn->error;die();
    } 
  }
  
  $to=$_username;
  
  //$_password;
  /*
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

 */
 
	$_eventdata=get_eventdata("form_token='".$_GET['t']."'");
	
  $temp=select("select * from tbl_email_templates where status=1 and type=1 and eventid=".$_eventdata[0]['id']);
  
  $temp=$temp[0];
  $msg=$temp['content'];
  

  $msg=htmlentities($msg);
  $msg=str_replace("#email#",$_username,$msg);
  $msg=html_entity_decode($msg);
  $fromName='AKU POSTERS ';
  $from='noreply@akuposters.com';

  // Set content-type header for sending HTML email 
  $headers = "MIME-Version: 1.0" . "\r\n"; 
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 

  // Additional headers 
  $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
  $headers .= 'Cc: ' . "\r\n"; 
  $headers .= 'Bcc: ' . "\r\n"; 

  @mail($to,$temp['title'],$msg,$headers);

  $chat_password=$_password;
  $chat_email=$_username;
  $chat_user=substr($_username,0,strpos($_username,'@'));
  
  $qry="select u.*,p.firstname,p.lastname,p.email,r.role from tbl_users u 
		  inner join tbl_profile p on p.userid=u.userid
		  inner join tbl_roles r on r.roleid=u.roleid
		  where username='$_username' /*and password='$txt_password'*/";
	$result = mysqli_query($conn, $qry);

	if (mysqli_num_rows($result) > 0) {
	    
	    	while($row = mysqli_fetch_assoc($result)) {                
			if($row["username"]==$_username /*&& $row["password"]==$txt_password*/){

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
			}
	    	}
	}
	
	
  echo "User registered successfully, Please check your email for further details, and if you don't receive your email please check your junk email, for further assistance contact info@rspvirtualmeet.com";
  
  	
  
  
  echo "|".$chat_user."|".$chat_password."|".$chat_email;die();
}   
if(isset($_POST["hdndata"])){


  $fileinfo = @getimagesize($_FILES["file"]["tmp_name"]);
        
  $width = $fileinfo[0];  
  $height = $fileinfo[1];
  
  $target_dir = "uploads/profiles/";
  $target_file = $target_dir . basename($_FILES["file"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["file"]["tmp_name"]);
  if($check !== false) {         
    $uploadOk = 1;
    if(true){//if($width==352 && $height==458){
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.<br/>";
      } else {
        //echo "Sorry, there was an error uploading your file.";
        $uploadOk = 0;
      }
    }else
    {
     // echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
      $uploadOk = 0;
    }
  } else {
    if($_GET['type']=='edit'){
      $uploadOk = 1;
      $imagedit=0;
    }else{
    //echo "Please upload Image File";
    $uploadOk = 0;
    }
  }
  
  if($uploadOk==1){
    $_target_file=str_replace("../","",$target_file);
  }else{
    $_target_file='';
  }
  

  $data=$_POST["hdndata"];  
  $data=explode("|",$data);
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
    $eventid=$_POST["hdneventid"];
    
    $userqry="insert into tbl_users (username,password,roleid,status,eventid) values('$t_orbit_user','$t_orbit_pass',5,1,$eventid)";
    if($conn->query($userqry) === TRUE){
        $uid=mysqli_insert_id($conn);
        $profileqry="insert into  tbl_profile (userid,firstname,status) values('$uid','$t_orbit_user',1)";
        if($conn->query($profileqry) === TRUE){
            reg_user($data,$t_orbit_user,$t_orbit_pass,$id,$uid,$_target_file);
            
        }
    }        
  }
  else
  {
    echo "This email address is already registered.";die();
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
<style>
    input[name=designation], [name=Institute], [name=pmdc], [name=city], [name=country], [name=contact_no], [name=facebook], [name=twitter], [name=profile_pic], [name=orbit_password]   {display: none;}
</style>
</script>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title>AKU - 12th HSRA</title>
<meta content="" name="descriptison">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="assets/img/favicon.png" rel="icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="css.css" rel="stylesheet">

<!-- dependencies (jquery, handlebars and bootstrap) -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>

<!-- <link type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet"/> -->
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

<!-- alpaca -->
<link type="text/css" href="https://cdn.jsdelivr.net/npm/alpaca@1.5.27/dist/alpaca/bootstrap/alpaca.min.css" rel="stylesheet"/>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/alpaca@1.5.27/dist/alpaca/bootstrap/alpaca.min.js"></script>
<link rel="stylesheet" href="obt/assets/jAlert/jAlert.css">
<style>
body {
	background: url('<?=$bgimage?>') !important;
}
.loader {
	background-image: url(obt/assets/loader.gif)!important;
	background-repeat: no-repeat!important;
	background-position: right!important;
	background-position-x: 260px!important;
}
#canvas {
	width: 200px;
	height: 80px;
	float: left;
	margin-left: 17px;
}
</style>
<script type="text/javascript" src="captcha/alphanumeric-captcha/alphanumeric-captcha/js/jquery-captcha-lgh.js"></script>
</head>
<body>
<div class="container-login">
  <div class="login-page">
    <div class="form">
      <h2>Member Registration</h2>
  <div class="register-form">
    <div style="display:none" class="info">Info message</div>
    <div style="display:none" class="success">Successful operation message</div>
    <div style="display:none" class="warning">Warning message</div>
    <div style="display:none" class="error">Error message</div>
    <div style="display:none" class="validation">Validation message</div>
  </div>
  <?php
		$regform=get_all_regforms("form_token='$id'");
		//var code = "$('#div').alpaca(" + JSON.stringify(json, null, "    ") + ");";
	?>
  <form method="post" action="register.php?t=<?=$id?>" id="frm">
    <input type="hidden" value="" id="hdndata" name="hdndata"/>
    <input type="hidden" value="<?=$regform[0]['id'];?>" id="hdneventid" name="hdneventid"/>
    <!--<div class="row">
      <div class="col-sm-6">
        <canvas id="canvas" style="background:#fff"></canvas>
      </div>
      <div class="col-sm-6">
        <input name="code" class="form-control" placeholder="Type the Code" style="float: right;margin-right: 29px;">
      </div>
      
    </div> -->
    <button type="button" id="btnsub" onclick="submitreg()">create</button>
    <br/>
    <br />
    
  </form>
  <script>
      // step-1
      //const captcha = new Captcha($('#canvas'),{
      //  length: 4
      //});
      // api
      //captcha.refresh();
      //captcha.getCode();
      //captcha.valid("");

      // $('#valid').on('click', function() {
      //   const ans = captcha.valid($('input[name="code"]').val());
      //   alert(ans);
      //   captcha.refresh();
      // })
    </script> 
  <script type="text/javascript">
		var json='<?=$regform[0]['regform'];?>';
    json=JSON.parse(json);
  json["postRender"]=function(control) {
       
    $(".alpaca-container").append('<input name="orbit_username" type="text" placeholder="Email"/>');
    $(".alpaca-container").append('<input name="orbit_password" type="password" placeholder="password" />');
        setTimeout(function(){ 
          $('.alpaca-container-item').addClass('reg_form');
    //  $('[data-alpaca-container-item-name=profile_pic]').removeClass('reg_form');
    //  $('[data-alpaca-container-item-name=profile_pic]').addClass('profile_pic'); 
    
            
        }, 500);
    }
		$(".register-form").alpaca(json);
		
   
    //$(".register-form").append('<button id="btnsub" onclick="submitreg()">create</button>');
    
    function ValidateEmail() 
    {
      
      if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($('[name=orbit_username]')[0].value))
      {
        return (true)
      }
      err_msg('You have entered an invalid email address!');      
      return (false)
    }
    function create_chat_user(text)
    {
      
      $.ajax({
              type:'POST',
              url:'blabax/account.php?q=register',
              data:"regname="+window.chat_user+"&password="+window.chat_password+"&email="+window.chat_email+"&question=what is yourname?&answer=myname is ",
              success:function(res){
                $('input').val('');
                succ_msg(text);
                  //login_chat_user(text);
                  }            
              });      
      }

    function submitreg()
    {
      $('#btnsub').addClass('loader');
     /* const ans = captcha.valid($('input[name="code"]').val());
      if(!ans){
           err_msg('Incorrect captcha');
        return;
      }*/
      if(validateForm())
      {
        /*if(!validateForm()){
            return false;
        }*/
        var form_data=[];
        $('.register-form input').each(function(){
          form_data[$(this).attr('name')]=$(this).val();
        });

        var _data="";
        for(a in form_data)
        {
            _data+=a+"="+form_data[a]+"|";
        }

        $('#hdndata').val(_data);

       // var fd = new FormData();
      //  var files =  $('input[type=file]')[0].files;

      //  fd.append('hdndata',_data);
      //  fd.append('hdneventid',$('#hdneventid').val());
     //   if(files.length > 0 ){
     //      fd.append('file',files[0]);
     //   }
        // data:"hdndata="+_data+"&hdneventid="+$('#hdneventid').val(),
        $.ajax({
              type:'POST',
              url:'register.php?t=<?=$id?>',
              data:"hdndata="+_data+"&hdneventid="+$('#hdneventid').val(),
            
              success:function(res){
                    //upload_file();
                    userc=res.split('|');
                    window.chat_user=userc[1];
                    window.chat_password=userc[2];
                    window.chat_email=userc[3];
                    if(userc.length>1){
                      //succ_msg(userc[0]);
                      location.href="/obt/index.php"
                    }else{
                      err_msg(userc[0]);
                    }
                  }            
              });  
        //$('#frm').submit();    
      }else{
        $('#btnsub').removeClass('loader');
      }
    }
    function upload_file(){
      var fd = new FormData();
        var files =  $('input[type=file]')[0].files;

        fd.append('hdndata',"test");
        fd.append('hdneventid',$('#hdneventid').val());
        
        if(files.length > 0 ){
           fd.append('file',files[0]);
           $.ajax({
              url: 'register.php?t=<?=$id?>',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
                 if(response != 0){
                    $("#img").attr("src",response); 
                    $(".preview img").show(); // Display image element
                 }else{
                    alert('file not uploaded');
                 }
              },
           });
        }
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
    
     function validateForm(){
      msg='';
      cntr=0;
      
      try{
          var files =  $('input[type=file]')[0].files;
          if(files && files[0].size>9437184)
          {
              $('input[type=file]').focus();
            cntr++;
            msg+=cntr+'. File size must be less than 9 MB<br/>';
          }
      }catch(e){}
      if($('[name=Name]').val().trim().length<=0)
      {
        
        $('[name=Name]').focus();
        cntr++;
        msg+=cntr+'. Please enter Name<br/>';
      }
     /* if($('[name=designation]').val().trim().length<=0)
      {
        $('[name=designation]').focus();
        cntr++;
        msg+=cntr+'. Please enter Designation<br/>';
      }
      if($('[name=Institute]').val().trim().length<=0)
      {
        $('[name=Institute]').focus();
        cntr++;
        msg+=cntr+'. Please enter Institute<br/>';
      }*/
     /* if($('[name=pmdc]').val().trim().length<=0)
      {
        $('[name=pmdc]').focus();
        cntr++;
        msg+=cntr+'. Please enter PMDC<br/>';
      }*//*
      if($('[name=city]').val().trim().length<=0)
      {
        $('[name=city]').focus();
        cntr++;
        msg+=cntr+'. Please enter City<br/>';
      } 
      if($('[name=country]').val().trim().length<=0)
      {
        $('[name=country]').focus();
        cntr++;
        msg+=cntr+'. Please enter Country<br/>';
      }   
      if($('[name=contact_no]').val().trim().length<=0)
      {
        $('[name=contact_no]').focus();
        cntr++;
        msg+=cntr+'. Please enter Contact No<br/>';
      }  
*/
      if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($('[name=orbit_username]')[0].value))
      {
        
      }
      else
      {
        $('[name=orbit_username]').focus();
        cntr++;
        msg+=cntr+'. Please enter valid email address <br/>';
      }

      // if($('[name=orbit_username]').val().trim().length<=0)
      // {
      //   $('[name=orbit_username]').focus();
      //   cntr++;
      //   msg+=cntr+'. Please enter Username<br/>';
      // }  
      /*if($('[name=orbit_password]').val().trim().length<=0)
      {
        $('[name=orbit_password]').focus();
        cntr++;
        msg+=cntr+'. Please enter Password<br/>';
      }   */     

      if(msg.length>0){
        validation_msg(msg);
        return false;
      }
      return true;
    }
    
    
   
	</script> 
</div></div></div>
<!-- form -->
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
<script src="obt/assets/jAlert/jAlert.min.js"></script> 
<script src="obt/assets/jAlert/jAlert-functions.min.js"></script> <!-- COMPLETELY OPTIONAL -->

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
