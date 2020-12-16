<?php include('inc/header.php');
$msg='';
$id=$_SESSION['eventdata'][0]['form_token'];
$bgimage='bg.jpg';
if(isset($_SESSION['eventdata'][0]['form_token'])){
$form_token=$_SESSION['eventdata'][0]['form_token'];
  $eventdata=get_eventdata("form_token='$form_token'");
  //echo $_SESSION['eventdata'][0]['form_token'];
	$bgimage=$eventdata[0]['eventbgimage'];
  $usid=$_SESSION['userdata']['userid'];
 $qry="select * from tbl_register where userid=$usid";
  $user_profile=select($qry);

  $data=array();
  $res='';
  for($i=0;$i<sizeof($user_profile);$i++)
  {
    $_pro=$user_profile[$i];
    //$data[$_pro['fieldname']]=$_pro['fieldvalue'];
    $res=$res.$_pro['fieldname']."^".$_pro['fieldvalue']."|";

  }

	//$bgimage=(str_len($bgimage)>0)?$bgimage:'bg.jpg';
}
function update_reg_user($data,$_username,$_password,$id,$uid,$profile_pic){
  global $conn;
  $formid=get_new_formid();
  $res=1;
  $_name='';
  for($i=0;$i<sizeof($data)-1;$i++)
  {    
    $val=explode('=',$data[$i]);
    
    $chk=select("select * from tbl_register where userid=$uid and fieldname='$val[0]'");
    if(sizeof($chk)>0){
        $qry="update tbl_register set fieldvalue='$val[1]'  where fieldname='$val[0]' and form_token='$id' and userid=$uid ";    
    }else{
        $qry="insert into tbl_register (fieldvalue,fieldname,form_token,userid,formid) values('$val[1]','$val[0]','$id',$uid,$formid) ";    
    }
    
    if($val[0]=='Name'){       
      $_name=$val[1];      
    }
    if ($conn->query($qry) === TRUE){     
    }else{
      echo "Error: " . $qry . "|" . $conn->error;die();
    } 
  }
  if(strlen($profile_pic)>0){
    $qry="update  tbl_register set fieldvalue='$profile_pic' where fieldname='profile_pic' and form_token='$id' and userid=$uid ";
    if ($conn->query($qry) === TRUE){     
    }else{
      echo "Error: " . $qry . "|" . $conn->error;die();
    } 
  }
  
  echo "Profile updated successfully.";
  echo "|".$chat_user."|".$chat_password."|".$chat_email;die();
}   



if(isset($_POST["hdndata"])){

    
    echo '<hr>';
    
  $fileinfo = @getimagesize($_FILES["file"]["tmp_name"]);
        
  $width = $fileinfo[0];  
  $height = $fileinfo[1];
  $uploadOk = 1;
  if($_FILES["file"]["error"]==0){
      
  $target_dir = "uploads/profiles/";
  $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["file"]["tmp_name"]);
  if($check !== false) {         
    $uploadOk = 1;
    if(true){//if($width==352 && $height==458){
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.<br/>";
      } else {
        echo "Sorry, there was an error uploading your file.";
        $uploadOk = 0;
      }
    }else
    {
      echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
      $uploadOk = 0;
    }
  } else {
    if($_GET['type']=='edit'){
      $uploadOk = 1;
      $imagedit=0;
    }
  }
  
  if($uploadOk==1){
    $_target_file=str_replace("../","",$target_file);
  }else{
    $_target_file='';
  }
  }
  
  if($_FILES["file"]["error"]==0)
  {
      
      $_target_file="";
  }
  

  $data=$_POST["hdndata"];  
  
  $data=explode("|",$data);
  $user_exists=0;
  $t_orbit_user='';
  $t_orbit_pass='';
  $t_userid=0;
  for($i=0;$i<sizeof($data)-1;$i++){
    $val=explode('=',$data[$i]);

    if($val[0]=='orbit_username')
    {
      $username=$val[1];
      $t_orbit_user=$username;
      $qry_uc=select("select * from tbl_users where username='$username'");
      if(sizeof($qry_uc)>0)
      {
           $t_userid=$qry_uc[0]['userid'];
        $user_exists=1;
      }
    }
    
  }
  
  if($user_exists==1)
  {
    $eventid=$_POST["hdneventid"];
    if(strlen($t_orbit_pass)>0)
    $userqry="update tbl_users set password='$t_orbit_pass' where userid=".$t_userid;
    if($conn->query($userqry) === TRUE){
        $uid=mysqli_insert_id($conn);
    }        
    update_reg_user($data,$t_orbit_user,$t_orbit_pass,$id,$t_userid,$_target_file);
  }
 
}
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.css">

<!-- dependencies (jquery, handlebars and bootstrap) -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>

<!-- alpaca -->
<link type="text/css" href="https://cdn.jsdelivr.net/npm/alpaca@1.5.27/dist/alpaca/bootstrap/alpaca.min.css" rel="stylesheet"/>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/alpaca@1.5.27/dist/alpaca/bootstrap/alpaca.min.js"></script>
</head>
<body>

<!-- ======= Header ======= -->

<header id="header">
  <div class="container">
    <div id="logo" class="pull-left"> </div>
    <?php include('inc/nav.php');?>
    <!-- #nav-menu-container --> 
    
  </div>
</header>

<!-- End Header --> 

<!-- ======= Intro Section ======= -->
<section id="contact" class="section-bg">
  <div class="container" data-aos="fade-up">
    <div class="section-header">
      <h2>Profile</h2>
    </div>
    <div class="form">
      <?php

		$regform=get_all_regforms("form_token='".$_SESSION['eventdata'][0]['form_token']."'");
		//var code = "$('#div').alpaca(" + JSON.stringify(json, null, "    ") + ");";
	?>
      <form action="profile.php?t=<?=$id?>" id="frm" method="POST" role="form"  >
        <div class="form-row"> </div>
        <div class="mb-3">
          <div class="loading"></div>
          <div class="error-message"></div>
          <div class="sent-message">
            <?=$msg?>
          </div>
        </div>
        <input type="hidden" value="" id="hdndata" name="hdndata"/>
        <input type="hidden" value="<?=$regform[0]['id'];?>" id="hdneventid" name="hdneventid"/>
        <div class="text-center">
          <button type="button" name="btn_submit" onclick="submitreg()">Update Profile</button>
        </div>
      </form>
      <script type="text/javascript">
		var json='<?=$regform[0]['regform'];?>';
  json=JSON.parse(json);
  
  
  json["postRender"]=function(control) {
       
    $(".alpaca-container").append('<input class="form-control" name="orbit_username" type="text" placeholder="Email" readonly/>');
        setTimeout(function(){ 
          $('.alpaca-container-item').addClass('reg_form');
    
            
        }, 500);

        _pdata='<?=$res?>';
      _pdata=_pdata.split('|');
      for(i=0;i<_pdata.length;i++)
      {
        _pdata_val=_pdata[i].split('^');
        if(_pdata_val[0]!='profile_pic'){
            try{
          $('[name='+_pdata_val[0]+']').val(_pdata_val[1]);
            }catch(e){}
        }
      }
    }
		$(".form-row").alpaca(json);
		

    
    function ValidateEmail() 
    {
      
      if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($('[name=orbit_username]')[0].value))
      {
        return (true)
      }
      err_msg('You have entered an invalid email address!');      
      return (false)
    }
   
    function submitreg()
    {
      if(validateForm())
      {
        var form_data=[];
        $('.form-row input').each(function(){
          form_data[$(this).attr('name')]=$(this).val();
        });

        var _data="";
        for(a in form_data)
        {
            _data+=a+"="+form_data[a]+"|";
        }

        $('#hdndata').val(_data);


        $.ajax({
              type:'POST',
              url:'profile.php?t=<?=$_SESSION['eventdata'][0]['form_token']?>',
                data:"hdndata="+_data+"&hdneventid="+$('#hdneventid').val(),
              success:function(res){
                    
                    userc=res.split('|');
                    window.chat_user=userc[1];
                    window.chat_password=userc[2];
                    window.chat_email=userc[3];
                    if(userc.length>1){
                      succ_msg(userc[0]);
                    }else{
                      err_msg(userc[0]);
                    }
                  }            
              });  
      }else{
        $('#btnsub').removeClass('loader');
      }
    }
    
    function err_msg(msg){
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
      
      var files =null;
      try{
          
     files  =  $('input[type=file]')[0].files;
      if(files && files[0].size>4437184)
      {
          $('input[type=file]').focus();
        cntr++;
        msg+=cntr+'. File size must be less than 10 MB<br/>';
      }
      }catch(e){}
      if($('[name=Name]').val().trim().length<=0)
      {
        
        $('[name=Name]').focus();
        cntr++;
        msg+=cntr+'. Please enter Name<br/>';
      }

      if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($('[name=orbit_username]')[0].value))
      {
        
      }
      else
      {
        $('[name=orbit_username]').focus();
        cntr++;
        msg+=cntr+'. Please enter valid email address <br/>';
      }

      if(msg.length>0){
        validation_msg(msg);
        return false;
      }
      return true;
    }
    
    
    $(document).ready(function(){
        
       $('input[type=file]').on('change', function() {
    
            try{
            
            var files =  $('input[type=file]')[0].files;
                  if(files && files[0].size>4194304 )
                  {
                      $('input[type=file]').focus();
                    alert('File size must be less than 4 MB');
                    $('input[type=file]').val('');
                  }
            }catch(e){}
            
            });     
    });
    
    
	</script> 
    </div>
  </div>
</section>

<?php include('inc/footer.php');?>