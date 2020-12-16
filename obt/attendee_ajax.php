<?php
    include('inc/top.php');
    include('attendees_icon.php');
//search
    if($_GET['action']=='search'){
        $txt=$_GET['txt'];
        $cnt=$_GET['cnt'];
        $search_res=select("select distinct userid  from tbl_register where fieldvalue like '%$txt%'");
       
        for($k=0;$k<sizeof($search_res);$k++){
          
        $_user_id=$search_res[$k]['userid'];
    $attendees=get_all_attendees("p.userid=$_user_id and eventid=".$_SESSION['eventdata'][0]['id'],"");

    for($i=0;$i<sizeof($attendees);$i++){

        $profile_pic='https://bootdey.com/img/Content/avatar/avatar1.png';
        $attendees_info=get_all_attendees2("r.userid=".$attendees[$i]['userid']." and r.fieldname='profile_pic'");
        for($j=0;$j<sizeof($attendees_info);$j++){
          if($attendees_info[$j]['fieldname']=='profile_pic')
          {
            $profile_pic="../".$attendees_info[$j]['fieldvalue'];
          }
          
        }
        
        
        if($profile_pic=='../'){
          $profile_pic='';
        }
        if(strlen($profile_pic)<=0){
          $profile_pic='https://bootdey.com/img/Content/avatar/avatar1.png';
        }
        
        $_name='';
        $attendees_info=get_all_attendees2("r.userid=".$attendees[$i]['userid']." and r.fieldname='Name'");
        for($j=0;$j<sizeof($attendees_info);$j++){
          if($attendees_info[$j]['fieldname']=='Name')
          {
            $_name=$attendees_info[$j]['fieldvalue'];
          }
          
        }
?>

<?php if(strlen($_name)>0){ ?>
<div class="member-entry"> <a href="#" class="member-img"> <img src="<?=$profile_pic?>" class="img-rounded"> <i class="fa fa-forward"></i> </a>
  <div class="member-details">
    <h4> <a href="#">
      <?=$_name?>
      </a> </h4>
    <div class="row info-list">
      <?php $attendees_info=get_all_attendees2('r.userid='.$attendees[$i]['userid']);
        for($j=0;$j<sizeof($attendees_info);$j++){
          if($j==0){
          ?>
      <div class="col-sm-4"> <i class="<?=$icons[$attendees_info[$j]['fieldname']]?>"></i> <a href="#">
        <?=$attendees_info[$j]['fieldvalue']?>
        </a> </div>
      <?php } else{?>
      <div class="col-sm-4"> <i class="<?=$icons[$attendees_info[$j]['fieldname']]?>"></i>
        <?=($attendees_info[$j]['fieldname']=='profile_pic')?'':$attendees_info[$j]['fieldvalue']?>
        </a> </div>
      <?php }?>
      <?php }?>
    </div>
  </div>
</div>
<?php }?>

<?php }

      }
    }
      
      //fetchall
    if($_GET['action']=='fetchall'){
        $cnt=$_GET['cnt'];
        $start=$_GET['start'];
    $attendees=get_all_attendees("eventid=".$_SESSION['eventdata'][0]['id'],"$start,$cnt");
    for($i=0;$i<sizeof($attendees);$i++){

        $profile_pic='https://bootdey.com/img/Content/avatar/avatar1.png';
        $attendees_info=get_all_attendees2("r.userid=".$attendees[$i]['userid']." and r.fieldname='profile_pic'");
        for($j=0;$j<sizeof($attendees_info);$j++){
          if($attendees_info[$j]['fieldname']=='profile_pic')
          {
            $profile_pic="../".$attendees_info[$j]['fieldvalue'];
          }
          
        }
        if($profile_pic=='../'){
          $profile_pic='';
        }
        if(strlen($profile_pic)<=0){
          $profile_pic='https://bootdey.com/img/Content/avatar/avatar1.png';
        }
        
        $_name='';
        $attendees_info=get_all_attendees2("r.userid=".$attendees[$i]['userid']." and r.fieldname='Name'");
        for($j=0;$j<sizeof($attendees_info);$j++){
          if($attendees_info[$j]['fieldname']=='Name')
          {
            $_name=$attendees_info[$j]['fieldvalue'];
          }
          
        }
?>

<?php if(strlen($_name)>0){ ?>

<div class="member-entry"> <a href="#" class="member-img"> <img src="<?=$profile_pic?>" class="img-rounded"> <i class="fa fa-forward"></i> </a>
  <div class="member-details">
    <h4> <a href="#">
      <?=$_name?>
      </a> </h4>
    <div class="row info-list">
      <?php $attendees_info=get_all_attendees2('r.userid='.$attendees[$i]['userid']);
        for($j=0;$j<sizeof($attendees_info);$j++){
          if($j==0){
          ?>
      <div class="col-sm-4"> <i class="<?=$icons[$attendees_info[$j]['fieldname']]?>"></i> <a href="#">
        <?=$attendees_info[$j]['fieldvalue']?>
        </a> </div>
      <?php } else{?>
      <div class="col-sm-4"> <i class="<?=$icons[$attendees_info[$j]['fieldname']]?>"></i>
        <?=($attendees_info[$j]['fieldname']=='profile_pic')?'':$attendees_info[$j]['fieldvalue']?>
        </a> </div>
      <?php }?>
      <?php }?>
    </div>
  </div>
</div>
    <?php } ?>
<?php }

      }
?>