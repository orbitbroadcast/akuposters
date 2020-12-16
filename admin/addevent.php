<?php 
  include('inc/header.php'); 
  include('inc/SimpleImage.php'); 

  $_id='';
  $_etitle='';
  $_hasmain='';
  $_main_url='';
  $_halls='';
  $_noofhalls='';
  $_poster='';
  $_abstract='';
  $_exhibitor='';
  $_biography='';
  $_networking='';
  $_help_desk='';
  $_attendees='';
  $_sponsors='';
  $_noofsponsor='';
  $_eventbgimage='';
  $_status='';
  $_regform='';
  $_form_token='';
  $_view='';

  

  if(isset($_GET['type']) && $_GET['type']=='edit')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $events=select('select * from  tbl_eventsnew where id='.$id);
    if(sizeof($events)>0)
    {
      $_id=$id;
      $_etitle=$events[0]['etitle'];
      $_hasmain=$events[0]['hasmain'];
      $_main_url=$events[0]['main_url'];
      $_halls=$events[0]['halls'];
      $_noofhalls=$events[0]['noofhalls'];
      $_poster=$events[0]['poster'];
      $_abstract=$events[0]['abstract'];
      $_exhibitor=$events[0]['exhibitor'];
      $_biography=$events[0]['biography'];
      $_networking=$events[0]['networking'];
      $_help_desk=$events[0]['help_desk'];
      $_attendees=$events[0]['attendees'];
      $_sponsors=$events[0]['sponsors'];
      $_noofsponsor=$events[0]['noofsponsor'];
      $_eventbgimage=$events[0]['eventbgimage'];
      $_status=$events[0]['status'];
      $_regform=$events[0]['regform'];
      $_form_token=$events[0]['form_token'];
    }
  }
  elseif(isset($_GET['type']) && $_GET['type']=='del')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $_dqry="delete from  tbl_eventsnew where id=".$id;
    if ($conn->query($_dqry) === TRUE)
    {
      $_dqry1="delete from  tbl_eventdates where id=".$id;
      $conn->query($_dqry1); 
      $_dqry2="delete from  tbl_eventhalls where id=".$id;
      $conn->query($_dqry2);
      $_dqry3="delete from  tbl_eventsponsors where id=".$id;
      $conn->query($_dqry3);

      ?><script>location.href='events.php';</script><?php
    }
    
  }
  elseif(isset($_GET['id']))
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $events=select('select * from tbl_eventsnew where id='.$id);
    if(sizeof($events)>0)
    {
      $_id=$id;
      $_etitle=$events[0]['etitle'];
      $_hasmain=$events[0]['hasmain'];
      $_main_url=$events[0]['main_url'];
      $_halls=$events[0]['halls'];
      $_noofhalls=$events[0]['noofhalls'];
      $_poster=$events[0]['poster'];
      $_abstract=$events[0]['abstract'];
      $_exhibitor=$events[0]['exhibitor'];
      $_biography=$events[0]['biography'];
      $_networking=$events[0]['networking'];
      $_help_desk=$events[0]['help_desk'];
      $_attendees=$events[0]['attendees'];
      $_sponsors=$events[0]['sponsors'];
      $_noofsponsor=$events[0]['noofsponsor'];
      $_eventbgimage=$events[0]['eventbgimage'];
      $_status=$events[0]['status'];
      $_regform=$events[0]['regform'];
      $_form_token=$events[0]['form_token'];
        $_view='disabled';
    }
  }
  
?>

<?php

    if(isset($_POST['btn_submit'])){
        extract($_POST);
        
        $chk_main=isset($chk_main)?$chk_main:0;
        $chk_halls=isset($chk_halls)?$chk_halls:0;
        $chk_poster=isset($chk_poster)?$chk_poster:0;
        $chk_abstract=isset($chk_abstract)?$chk_abstract:0;
        $chk_exhibitor=isset($chk_exhibitor)?$chk_exhibitor:0;
        $chk_biography=isset($chk_biography)?$chk_biography:0;
        $chk_networking=isset($chk_networking)?$chk_networking:0;
        $chk_help_desk=isset($chk_help_desk)?$chk_help_desk:0;
        $chk_attendees=isset($chk_attendees)?$chk_attendees:0;
        $chk_sponsors=isset($chk_sponsors)?$chk_sponsors:0;
        $chk_status=isset($chk_status)?$chk_status:0;
        $form=mysqli_escape_string($conn,$hdn_regform);
        $form_token=time().'-'.rand(99,time());
        if($_GET['type']=='edit'){
          $form_token=$_form_token;
        }
        
        $createdby=$_SESSION['userdata']['userid'];
        $ddlNoOfHalls=(strlen($ddlNoOfHalls)>0)?$ddlNoOfHalls:0;
        $ddlNoOfSponsors=(strlen($ddlNoOfSponsors)>0)?$ddlNoOfSponsors:0;
        $fileinfo = @getimagesize($_FILES["txt_eventbgimage"]["tmp_name"]);
        
        $width = $fileinfo[0];  
        $height=$fileinfo[1];
        
        $target_dir = "../uploads/events/";
        $target_file = $target_dir . basename($_FILES["txt_eventbgimage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["txt_eventbgimage"]["tmp_name"]);
        $imagedit=1;
        if($check !== false) {         
          $uploadOk = 1;
          if(true){//if($width==352 && $height==458){
            if (move_uploaded_file($_FILES["txt_eventbgimage"]["tmp_name"], $target_file)) {
              echo "The file ". basename( $_FILES["txt_eventbgimage"]["name"]). " has been uploaded.<br/>";
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
          }else{
          echo "Please upload Image File";
          $uploadOk = 0;
          }
        }
        $_target_file=str_replace("../","",$target_file);


       $uploadOk=1;
        if($uploadOk==1){

          if(isset($_GET['type']) && $_GET['type']=='edit')
          {           
            $txt_etitle=mysqli_escape_string($conn,$txt_etitle);
            $txt_webinarurl=mysqli_escape_string($conn,$txt_webinarurl);
            
            if($imagedit==0){
              $qry="update tbl_eventsnew set etitle='$txt_etitle',
                                        hasmain=$chk_main,
                                        main_url='$txt_webinarurl',
                                        halls=$chk_halls,
                                        noofhalls=$ddlNoOfHalls,
                                        poster=$chk_poster,
                                        abstract=$chk_abstract,
                                        exhibitor=$chk_exhibitor,
                                        biography=$chk_biography,
                                        networking=$chk_networking,
                                        help_desk=$chk_help_desk,
                                        attendees=$chk_attendees,
                                        sponsors=$chk_sponsors,
                                        noofsponsor=$ddlNoOfSponsors,
                                        status=$chk_status,
                                        regform='$form',
                                        form_token='$form_token'
                                        where id=$hdn_eventid";
            }else{
            $qry="update tbl_eventsnew set etitle='$txt_etitle',
                                        hasmain=$chk_main,
                                        main_url='$txt_webinarurl',
                                        halls=$chk_halls,
                                        noofhalls=$ddlNoOfHalls,
                                        poster=$chk_poster,
                                        abstract=$chk_abstract,
                                        exhibitor=$chk_exhibitor,
                                        biography=$chk_biography,
                                        networking=$chk_networking,
                                        help_desk=$chk_help_desk,
                                        attendees=$chk_attendees,
                                        sponsors=$chk_sponsors,
                                        noofsponsor=$ddlNoOfSponsors,
                                        eventbgimage='$_target_file',
                                        status=$chk_status,
                                        regform='$form',
                                        form_token='$form_token'
                                        where id=$hdn_eventid";
            }
                if ($conn->query($qry) === TRUE) {
                  echo "Record updated successfully";
                  
                  //$delqry1="delete from tbl_eventdates where eventid=$hdn_eventid";
                  
                  for($i=0;$i<sizeof($txt_edatetime);$i++)
                    {
                      $edate=$txt_edatetime[$i];
                      $edate_id=$hdn_edatetime[$i];
                      if($edate_id>0){
                        $dateqry="update tbl_eventdates set edate='$edate' where eventid=$hdn_eventid and edateid=$edate_id";
                        if ($conn->query($dateqry) === TRUE) 
                        {
                          //echo "Date added successfully";
                          $cntr=$i+1;
                          $agendaqry="update tbl_agenda set adate='$edate' where eventid=$hdn_eventid and edateid=$edate_id";
                          $conn->query($agendaqry);

                        } 
                        else {echo "Error: " . $dateqry . "<br>" . $conn->error;}
                      }else
                      {
                        $dateqry="insert into tbl_eventdates (edate,eventid) values('$edate',$hdn_eventid)";
                        if ($conn->query($dateqry) === TRUE) 
                        {
                          //echo "Date added successfully";
                          $cntr=$i+1;
                          $edateid=mysqli_insert_id($conn);
                          $agendaqry="insert into tbl_agenda (aday,adate,status,eventid,edateid) values ($cntr,'$edate',0,$hdn_eventid,$edateid)";
                          $conn->query($agendaqry);

                        } 
                        else {echo "Error: " . $dateqry . "<br>" . $conn->error;}
                      }
                    }

                    for($i=0;$i<sizeof($txt_hallUrl);$i++)
                    {
                      $hallurl=$txt_hallUrl[$i];
                      $hallurl=mysqli_escape_string($conn,$hallurl);
                      $hallurlid=$hdn_hallUrl[$i];

                      if($hallurlid>0)
                      {
                        $hallqry="update tbl_eventhalls set hallurl='$hallurl' where eventid=$hdn_eventid and hallurl_id=$hallurlid";
                      }
                      else
                      {
                        $hallqry="insert into tbl_eventhalls (hallurl,eventid) VALUES('$hallurl',$hdn_eventid)";
                      }
                      if ($conn->query($hallqry) === TRUE) 
                      {
                        //echo "Hall added successfully";
                      } 
                      else {echo "Error: " . $hallqry . "<br>" . $conn->error;}
                    }
                  $delqry3="delete from tbl_eventsponsors where eventid=$hdn_eventid";
                  if($conn->query($delqry3)===TRUE){
                    $imgindx=0;
                    foreach ($_FILES["txt_sponsorImage"]["error"] as $key => $error) 
                    {          
                      $_suploadOk =0;
                      if ($error == UPLOAD_ERR_OK || $error == 4) {
          
                          $name='';
                          if($error == UPLOAD_ERR_OK)
                          {
                            $tmp_name = $_FILES["txt_sponsorImage"]["tmp_name"][$key];              
                            $name = basename($_FILES["txt_sponsorImage"]["name"][$key]);   
                            $target_dir = "../uploads/sponsors/";
                            $target_file = $target_dir . basename($_FILES["txt_sponsorImage"]["name"][$key]); 
                            $name=$target_file;
                            
                            if (move_uploaded_file($_FILES["txt_sponsorImage"]["tmp_name"][$key], $target_file)) {
                              echo "The file ".  basename($_FILES["txt_sponsorImage"]["name"][$key]). " has been uploaded.<br/>";
                              $_suploadOk=1;
                            } else {
                              echo "Sorry, there was an error uploading your file.";
                              $_suploadOk = 0;
                            }

                            if($_suploadOk==1){
                              $sponsorqry="Insert Into tbl_eventsponsors (eventid,imageurl) values($hdn_eventid,'$name');";
                               if ($conn->query($sponsorqry) === TRUE) {                
                                 //echo "New record created successfully";
                               } else {
                               //echo "Error: " . $qry . "<br>" . $conn->error;
                               } 
                             }else{
                                $sponsorqry="Insert Into tbl_eventsponsors (eventid,imageurl) values($hdn_eventid,'$hdn_sponsorImage[$key]');";
                               if ($conn->query($sponsorqry) === TRUE) {                
                                 //echo "New record created successfully";
                               } else {
                               //echo "Error: " . $qry . "<br>" . $conn->error;
                               } 
                             } 

                             $imgindx++;
                          }



                          
                      }
                    }

                      for($im=$imgindx;$im<sizeof($hdn_sponsorImage);$im++)
                      {
                        $sponsorqry="Insert Into tbl_eventsponsors (eventid,imageurl) values($hdn_eventid,'$hdn_sponsorImage[$im]');";
                        if ($conn->query($sponsorqry) === TRUE) {                
                          //echo "New record created successfully";
                        } else {
                        //echo "Error: " . $qry . "<br>" . $conn->error;
                        } 
                      }
                  }
                  
                } else {
                  echo "Error: " . $qry . "<br>" . $conn->error;
                } 
          }
          else
          {
            $txt_etitle=mysqli_escape_string($conn,$txt_etitle);
            $txt_webinarurl=mysqli_escape_string($conn,$txt_webinarurl);
          $qry="insert into  tbl_eventsnew (etitle,hasmain,main_url,halls,noofhalls,poster,abstract,exhibitor,biography,networking,help_desk,attendees,sponsors,noofsponsor,eventbgimage,status,regform,form_token,createdby)
                           values('$txt_etitle',$chk_main,'$txt_webinarurl',$chk_halls,$ddlNoOfHalls,$chk_poster,$chk_abstract,$chk_exhibitor,$chk_biography,$chk_networking,$chk_help_desk,$chk_attendees,$chk_sponsors,$ddlNoOfSponsors,'$_target_file',$chk_status,'$form','$form_token',$createdby)";
                           if ($conn->query($qry) === TRUE)
                           {
                             
                               $eventid=mysqli_insert_id($conn);
                               for($i=0;$i<sizeof($txt_edatetime);$i++)
                               {
                                 $edate=$txt_edatetime[$i];
                                 $dateqry="insert into tbl_eventdates (eventid,edate) values($eventid,'$edate')";
                                 if ($conn->query($dateqry) === TRUE) 
                                 {
                                   //echo "Date added successfully";

                                   $cntr=$i+1;
                                   $edateid=mysqli_insert_id($conn);
                                   $agendaqry="insert into tbl_agenda (aday,adate,status,eventid,edateid) values ($cntr,'$edate',0,$eventid,$edateid)";
                                   $conn->query($agendaqry);
                                 } else {echo "Error: " . $dateqry . "<br>" . $conn->error;}
                               }
                 
                               for($i=0;$i<sizeof($txt_hallUrl);$i++)
                               {
                                 $hallurl=$txt_hallUrl[$i];
                                 $hallurl=mysqli_escape_string($conn,$hallurl);
                                 $hallqry="insert into tbl_eventhalls (eventid,hallurl) values($eventid,'$hallurl')";              
                                 if ($conn->query($hallqry) === TRUE) 
                                 {
                                   //echo "Hall added successfully";
                                 } else {echo "Error: " . $hallqry . "<br>" . $conn->error;}
                               }
                             
                 
                             $imgindx=0;
                             foreach ($_FILES["txt_sponsorImage"]["error"] as $key => $error) 
                             {          
                               if ($error == UPLOAD_ERR_OK || $error == 4) 
                               {
                                   $name='';
                                   if($error == UPLOAD_ERR_OK)
                                   {
                                     $tmp_name = $_FILES["txt_sponsorImage"]["tmp_name"][$key];              
                                     $name = basename($_FILES["txt_sponsorImage"]["name"][$key]);   
                                     $target_dir = "../uploads/sponsors/";
                                     $target_file = $target_dir . basename($_FILES["txt_sponsorImage"]["name"][$key]); 
                                     $name=$target_file;
                                     
                                     if (move_uploaded_file($_FILES["txt_sponsorImage"]["tmp_name"][$key], $target_file)) {
                                       echo "The file ".  basename($_FILES["txt_sponsorImage"]["name"][$key]). " has been uploaded.<br/>";
                                     } else {
                                       echo "Sorry, there was an error uploading your file.";
                                       $uploadOk = 0;
                                     }
                                   }
                                   $sponsorqry="Insert Into tbl_eventsponsors (eventid,imageurl) values($eventid,'$name');";
                                   if ($conn->query($sponsorqry) === TRUE) {                
                                     //echo "New record created successfully";
                                   } else {
                                    //echo "Error: " . $qry . "<br>" . $conn->error;
                                   }    
                                   $imgindx++;
                               }
                             }
                 
                 
                 
                             echo "New record created successfully";
                           } else {
                             echo "Error: " . $qry . "<br>" . $conn->error;
                           }   
          }                 
        }
    }

?>
    <!-- Main content -->
    <section class="content">

    <!-- Default box -->
    <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=get_page_name("formurl='".basename($_SERVER['PHP_SELF'])."'")[0]['formname'];?></h3>
        <div class="box-tools pull-right">
        <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button> -->
        <!-- <button class="btn btn-box-tool" onclick="javascript:location.href='events.php'" data-toggle="tooltip" title="Cancel"><i class="fa fa-times"></i></button> -->
        </div>
    </div>
    <!-- form start -->
    <form name="frmevent" role="form" method="post" enctype="multipart/form-data">
                  <input type="hidden" value="<?=$_id?>" name="hdn_eventid">
                  <input type="hidden" id="regform" name="hdn_regform" value="">
                  <input type="hidden" id="hdn_regform_edit" name="hdn_regform_edit" value="<?=htmlentities($_regform)?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="txt_title">Title</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_etitle" placeholder="Enter title" value="<?=$_etitle?>">
                    </div>
                    <div class="form-group">
                      <label for="txt_edatetime">Event Date</label>
                      
                    <?php
                    
                    $edates=get_event_dates("eventid=$_id");
                    for($i=0;$i<sizeof($edates);$i++){
                      $edate=$edates[$i];
                    ?>
                      <input <?=$_view?> type="date" class="form-control" name="txt_edatetime[]" placeholder="Enter event datetime" value="<?=$edate['edate']?>">
                      <input type="hidden"  name="hdn_edatetime[]" value="<?=$edate['edateid']?>">
                      <?php
                            }
                      ?>
                    </div>  
                   

                    <button type="button" onclick="addDate(this)">Add date</button>
                    <div class="checkbox">
                      <label>                     
                        <input <?=$_view?> type="checkbox" name="chk_main" onchange="enableURLField(this)" value="1" <?=($_hasmain==1)?'checked':''?>> Main Plenary
                      </label>
                    </div>  
                    <div class="form-group">
                      <label for="txt_webinarurl">Webinar Url</label>
                      <input <?=$_view?> type="text" class="form-control" id="txt_webinarurl" name="txt_webinarurl" placeholder="Enter webinar url" value="<?=$_main_url?>" <?=($_hasmain==1 && $_view=='')?'':'disabled'?>>
                    </div>   
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> onchange="enableHallField(this)" type="checkbox" name="chk_halls" value="1" <?=($_halls==1)?'checked':''?>> Hall 
                      </label>
                      <select <?=$_view?> id="ddlNoOfHalls" name="ddlNoOfHalls" onchange="addHallURL(this)" <?=($_halls==1 && $_view=='')?'':'disabled'?>>
                        <option <?=($_noofhalls==0)?'selected':''?> value="0">-- Select No. of Halls --</option>
                        <option <?=($_noofhalls==1)?'selected':''?> value="1">1</option>
                        <option <?=($_noofhalls==2)?'selected':''?> value="2">2</option>
                        <option <?=($_noofhalls==3)?'selected':''?> value="3">3</option>
                        <option <?=($_noofhalls==4)?'selected':''?> value="4">4</option>
                        <option <?=($_noofhalls==5)?'selected':''?> value="5">5</option>
                      </select>                                                                  
                    </div>        
                    <div class="form-group" id="divHallURL">
                      <label>Session Url</label><br/>
                      <?php
                        $halls=get_event_halls("eventid=$_id");
                        for($i=0;$i<sizeof($halls);$i++){
                          $hall=$halls[$i];
                      ?>

                        <strong>Session <?=($i+1)?></strong>
                        <input <?=$_view?> type="text" class="form-control" name="txt_hallUrl[]" placeholder="Enter video url" value="<?=$hall['hallurl']?>">
                        <input <?=$_view?> type="hidden" name="hdn_hallUrl[]" value="<?=$hall['hallurl_id']?>">
                        <?php }?>
                    </div>    
                    
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_poster" value="1" <?=($_poster==1)?'checked':''?>> Poster
                      </label>
                    </div> 
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_abstract" value="1" <?=($_abstract==1)?'checked':''?>> Abstract
                      </label>
                    </div> 
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_exhibitor" value="1" <?=($_exhibitor==1)?'checked':''?>> Exhibitor
                      </label>
                    </div> 
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_biography" value="1" <?=($_biography==1)?'checked':''?>> Biography
                      </label>
                    </div> 
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_networking" value="1" <?=($_networking==1)?'checked':''?>> Networking
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_help_desk" value="1" <?=($_help_desk==1)?'checked':''?>> Help desk
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_attendees" value="1" <?=($_attendees==1)?'checked':''?>> Attendees
                      </label>
                    </div>      
                    <div class="checkbox">
                        <label>
                        <input <?=$_view?> onchange="enableSponsorField(this)" type="checkbox" name="chk_sponsors" value="1" <?=($_sponsors==1)?'checked':''?>> Sponsors Logos (Size = 100x50px)
                      </label>
                      <select <?=$_view?> id="ddlNoOfSponsors" name="ddlNoOfSponsors" onchange="addSponsorImage(this)" <?=($_sponsors==1 && $_view=='')?'':'disabled'?>>
                        <option <?=($_noofsponsor==0)?'selected':''?> value="0">-- Select No. of Sponsors --</option>
                        <option <?=($_noofsponsor==1)?'selected':''?> value="1">1</option>
                        <option <?=($_noofsponsor==2)?'selected':''?> value="2">2</option>
                        <option <?=($_noofsponsor==3)?'selected':''?> value="3">3</option>
                        <option <?=($_noofsponsor==4)?'selected':''?> value="4">4</option>
                        <option <?=($_noofsponsor==5)?'selected':''?> value="5">5</option>
                        <option <?=($_noofsponsor==6)?'selected':''?> value="6">6</option>
                        <option <?=($_noofsponsor==7)?'selected':''?> value="7">7</option>
                        <option <?=($_noofsponsor==8)?'selected':''?> value="8">8</option>
                        <option <?=($_noofsponsor==9)?'selected':''?> value="9">9</option>
                        <option <?=($_noofsponsor==10)?'selected':''?> value="10">10</option>
                      </select>    
                    </div>      
                    <div class="form-group" id="divSponsorImage">
                    <!-- <input type=file /> -->
                    <?php
                        $sponsors=get_event_sponsors("eventid=$_id");
                        
                        for($i=0;$i<sizeof($sponsors);$i++){
                          $sponsor=$sponsors[$i];
                      ?>

                        <input <?=$_view?> type="file" class="form-control" name="txt_sponsorImage[]" placeholder="Select Sponsor Logo">
                        <input type="hidden" value="<?=$sponsor['imageurl']?>" name="hdn_sponsorImage[]">
                        <img src="<?=$sponsor['imageurl']?>" height="50">
                      <?php }?>
                    </div>                    
                    <div class="form-group">
                      <label for="txt_eventbgimage">Event background image (Size=1600x1000px)</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_eventbgimage">
                      <?php
                        if($_eventbgimage!='')
                        {
                          ?>
                          <img src="../<?=$_eventbgimage?>" width="200">
                          <?php
                        }
                      ?>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_status" value="1" <?=($_status==1)?'checked':''?>> Active
                      </label>
                    </div> 
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <div id="form"></div>
                    <div class="row">
                <div class="col-md-12">
                    <div>
                        <ul class="nav nav-tabs">
                            <!-- <li ><a href="#source" data-toggle="tab" class="tab-item tab-item-source">Source</a></li> -->
                            <li class="active"><a href="#designer" data-toggle="tab" class="tab-item tab-item-designer">Designer</a></li>
                            <li><a href="#view" data-toggle="tab" class="tab-item tab-item-view">View</a></li>
                            <!-- <li><a href="#code" data-toggle="tab" class="tab-item tab-item-code">Code</a></li> -->
                            <!-- <li><a href="#loadsave" data-toggle="tab" class="tab-item tab-item-loadsave">Load / Save</a></li> -->
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane" id="source">
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <ul class="nav nav-tabs">
                                            <li><a href="#schema" data-toggle="tab" class="tab-source-schema">Schema</a></li>
                                            <li><a href="#options" data-toggle="tab" class="tab-source-options">Options</a></li>
                                            <li><a href="#data" data-toggle="tab" class="tab-source-data">Data</a></li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="schema">
                                        </div>
                                        <div class="tab-pane" id="options">
                                        </div>
                                        <div class="tab-pane" id="data">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <ul class="nav nav-tabs">
                                            <li ><a href="#preview" data-toggle="tab">Preview</a></li>
                                        </ul>
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="preview">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div id="previewDiv"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane active" id="designer">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="designerDiv"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#types" data-toggle="tab">Types</a></li>
                                                    <li><a href="#basic" data-toggle="tab">Basic</a></li>
                                                    <li><a href="#advanced" data-toggle="tab">Advanced</a></li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="types"></div>
                                                <div class="tab-pane" id="basic"></div>
                                                <div class="tab-pane" id="advanced"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="view">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="viewDiv"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="code">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="codeDiv"></div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane" id="loadsave">
                            <div class="row">
                                <div class="col-md-12">

                                    <button class="btn btn-default load-button">Load Form</button>
                                    <br/>
                                    <br/>
                                    <button class="btn btn-default save-button">Save Form</button>
                                    <br/>

                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
                    <button <?=$_view?> type="submit" class="btn btn-primary" name="btn_submit">Submit</button>
                  </div>
                </form>
    </div><!-- /.box -->

    </section><!-- /.content -->
<?php include('inc/footer.php');?>