<?php include('inc/header.php'); ?>
<?php
 

    if(isset($_POST['btn_submit_general'],$_POST['frm_type']) && $_POST['frm_type']=='general')
    {
        extract($_POST);
        $uqry="update tbl_exhibitor_new set company='$txt_company',contact_email='$txt_contact_email',url='$txt_url' where id=$hdn_id";
        if ($conn->query($uqry) === TRUE) 
        {
              $new_image = @imagecreatetruecolor(266, 300);
              @imagecopyresampled($new_image, $image, 0, 0, 0, 0, 266,300, $width, $height);
              $image = $new_image;
              
              if( $image_type == IMAGETYPE_JPEG ) {
                  imagejpeg($image,$target_file_thumb,75);
              } elseif( $image_type == IMAGETYPE_GIF ) {
          
                  imagegif($image,$target_file_thumb);
              } elseif( $image_type == IMAGETYPE_PNG ) {
          
                  imagepng($image,$target_file_thumb);
              }
              
              
            echo "Data saved successfully";
        }else 
        {
            echo "Error: " . $uqry . "<br>" . $conn->error;
        }   
    }


    //Fetch Data
    $event_id=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0;
    $qry="select * from tbl_exhibitor_new where email='".$_SESSION['userdata']['username']."' and eventid=$event_id";
    $res=select($qry);
    
    $_id='';
    $_firstname='';
    $_lastname='';
    $_email='';
    $_company='';
    $_job_title='';
    $_eventid='';
    $_contact_email='';
    $_url='';
    if(sizeof($res)>0){
        $general=$res[0];
        $_id=$general['id'];
        $_firstname=$general['firstname'];
        $_lastname=$general['lastname'];
        $_email=$general['email'];
        $_company=$general['company'];
        $_job_title=$general['job_title'];
        $_eventid=$general['eventid'];
        $_contact_email=$general['contact_email'];
        $_url=$general['url'];
    }
?>


<?php

$Id ='';
$Title='';
$ImageURL='';
$VideoURL='';
$PDFURL='';
$FAQ='';
$STATUS='';
$_view='';
$_category='';

  if(isset($_GET['type']) && $_GET['type']=='edit')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $user_data=select('select * from tbl_poster where Id='.$id);
    if(sizeof($user_data)>0)
    {

      $Id=$user_data[0]['Id'];
      $Title=$user_data[0]['Title'];
      $ImageURL=$user_data[0]['ImageURL'];
      $VideoURL=$user_data[0]['VideoURL'];
      $PDFURL=$user_data[0]['PDFURL'];
      $FAQ=$user_data[0]['FAQ'];
      $STATUS=$user_data[0]['STATUS'];
      $_category=$user_data[0]['category'];
    }

  }
  elseif(isset($_GET['type']) && $_GET['type']=='del')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $_dqry="delete from  tbl_poster where id=".$id;
    if ($conn->query($_dqry) === TRUE)
    {
      ?><script>location.href='posters.php';</script><?php
    }
    
  }
  elseif(isset($_GET['id']))
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $user_data=select('select * from tbl_poster where Id='.$id);
    if(sizeof($user_data)>0)
    {
      $Id=$user_data[0]['Id'];
      $Title=$user_data[0]['Title'];
      $ImageURL=$user_data[0]['ImageURL'];
      $VideoURL=$user_data[0]['VideoURL'];
      $PDFURL=$user_data[0]['PDFURL'];
      $FAQ=$user_data[0]['FAQ'];
      $STATUS=$user_data[0]['status'];
      $_category=$user_data[0]['category'];
      $_view='disabled';
    }

  }

    if(isset($_POST['btn_submit_poster'],$_POST['frm_type']) && $_POST['frm_type']=='poster')
    {
        extract($_POST);
        $txt_Title=mysqli_escape_string($conn,$txt_Title);
        $txt_VideoURL=mysqli_escape_string($conn,$txt_VideoURL);
        $txt_FAQ=mysqli_escape_string($conn,$txt_FAQ);

        $chk_status=isset($chk_status)?$chk_status:0;
		    $fileinfo = @getimagesize($_FILES["txt_Postimage"]["tmp_name"]);
        $width = $fileinfo[0];  
        $height = $fileinfo[1];
        $image_type = $fileinfo[2];
        
         if($image_type == IMAGETYPE_JPEG ) {
 
          $image = imagecreatefromjpeg($_FILES["txt_Postimage"]["tmp_name"]);
       } elseif( image_type == IMAGETYPE_GIF ) {
  
          $image = imagecreatefromgif($_FILES["txt_Postimage"]["tmp_name"]);
       } elseif( mage_type == IMAGETYPE_PNG ) {
  
          $image = imagecreatefrompng($_FILES["txt_Postimage"]["tmp_name"]);
       }
       
       
        $target_dir = "../uploads/poster/";
        $target_file = $target_dir . basename($_FILES["txt_Postimage"]["name"]);
        $target_file_thumb = $target_dir .'thumb_'. basename($_FILES["txt_Postimage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image

        $check = getimagesize($_FILES["txt_Postimage"]["tmp_name"]);
        if($check !== false) 
        {         
          $uploadOk = 1;
          if(true)
          {//if($width==352 && $height==458){
            if (move_uploaded_file($_FILES["txt_Postimage"]["tmp_name"], $target_file))
            {
                 echo $new_image = @imagecreatetruecolor(266, 300);
                 echo "|".$width;
                 echo "|".$height;
              @imagecopyresampled($new_image, $image, 0, 0, 0, 0, 266,300, $width, $height);
              
              $image = $new_image;
              
              if( $image_type == IMAGETYPE_JPEG ) {
                  imagejpeg($image,$target_file_thumb,75);
              } elseif( $image_type == IMAGETYPE_GIF ) {
          
                 imagegif($image,$target_file_thumb);
               
              } elseif( $image_type == IMAGETYPE_PNG ) {
          
                 imagepng($image,$target_file_thumb);
             
              }
              
              
              echo "The file ". basename( $_FILES["txt_Postimage"]["name"]). " has been uploaded.<br/>";
            }
            else
            {
              echo "Sorry, there was an error uploading your file.";
              $uploadOk = 0;
            }
          }
          else
          {
            echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
            $uploadOk = 0;
          }
        }
        else
        {
          //echo "Please upload Image File";
          $uploadOk = 0;
        }

        $_target_file=str_replace("../","",$target_file);
		    $fileinfo = @getimagesize($_FILES["txt_PostPDF"]["tmp_name"]);

        $width = $fileinfo[0];  
        $height = $fileinfo[1]; 

        $target_dir = "../uploads/poster/";
        $target_file2 = $target_dir . basename($_FILES["txt_PostPDF"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["txt_PostPDF"]["tmp_name"]);
        $pdfuploaded=0;
        if(true)
        {         //if($check !== false) {         
          //$uploadOk = 1;
          if(true)
          {//if($width==352 && $height==458){
            if (move_uploaded_file($_FILES["txt_PostPDF"]["tmp_name"], $target_file2))
            {
              echo "The file ". basename( $_FILES["txt_PostPDF"]["name"]). " has been uploaded.<br/>";
              $pdfuploaded=1;
            }
            else
            {
              

              if($hdn_poster_pdf==""){
                $uploadOk = 1;  
              }
              else{
             // $uploadOk = 0;
              //echo "Sorry, there was an error uploading your file.";
              }
            }
          }
          else
          {
            echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
            //$uploadOk = 0;
          }
        }
        else
        {
          echo "Please upload Image File";
         // $uploadOk = 0;
        }

        if($pdfuploaded==0 && $hdn_poster_pdf=="")
        {
          $_target_file2="";
        }
        else
        {
          $_target_file2=str_replace("../","",$target_file2);
        }

        if(substr($_target_file2,-4,1)!='.' && substr($_target_file2,-4)!='.pdf'){
            $_target_file2='';
        }
        if($uploadOk==1)
        {
          if($_GET['type']=='edit')
          {

            if($_FILES["txt_Postimage"]["error"]==4)
            {
              $qry="update tbl_poster set  Title='$txt_Title',              
              VideoURL='$txt_VideoURL',
              PDFURL='$_target_file2',
              FAQ='$txt_FAQ',
                status=$chk_status,
                category=$ddl_category
                where Id=$hdn_id";
            }
            else
            {
             $qry="update tbl_poster set  Title='$txt_Title',
              ImageURL='$_target_file',
              VideoURL='$txt_VideoURL',
              PDFURL='$_target_file2',
              FAQ='$txt_FAQ',
                status=$chk_status,
                category=$ddl_category
                where Id=$hdn_id";
            }
            

              if ($conn->query($qry) === TRUE)
            {
                echo "Record updated successfully";
            }
            else
            {
              echo "Error: " . $qry . "<br>" . $conn->error;
            }
          }
          else
          {
               $userid=$_SESSION['userdata']['userid'];
            $qry="insert into tbl_poster (Title,ImageURL,VideoURL,PDFURL,FAQ,status,eventid,category,createdby) values('$txt_Title','$_target_file','$txt_VideoURL','$_target_file2','$txt_FAQ',$chk_status,$hdn_event_top,$ddl_category,$userid)";
            if ($conn->query($qry) === TRUE)
            {
                echo "New record created successfully";
            }
            else
            {
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
            <h3 class="box-title">Exhibitor Dashboard</h3>
            <div class="box-tools pull-right">
            <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">                    
                        <li class="active"><a href="#general_tab" data-toggle="tab" aria-expanded="true"><strong>General</strong></a></li>
                        <li class=""><a href="#poster_tab" data-toggle="tab" aria-expanded="false"><strong>Poster</strong></a></li>
                        <li class=""><a href="#qanda_tab" data-toggle="tab" aria-expanded="false"><strong>Q & A</strong></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="general_tab">
                            <div class="box box-info">
                                <form role="form" method="post">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">General</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">                                    
                                            <input type="hidden" name="hdn_id" value="<?=$_id?>"/>
                                            <input type="hidden" name="frm_type" value="general"/>
                                            <table>
                                                <tr>
                                                    <th>Companyname</th>
                                                    <td><input type="text" name="txt_company" class="form-control" value="<?=$_company?>"/></td>
                                                </tr>
                                                <tr>
                                                    <th>Contact person name</th>
                                                    <td><input disabled type="text" class="form-control" name="txt_contact_person" value="<?=$_firstname?> <?=$_lastname?>"/></td>
                                                </tr>
                                                <tr>
                                                    <th>Contact person personal email</th>
                                                    <td><input disabled type="text" class="form-control" name="txt_email" value="<?=$_email?>"/></td>
                                                </tr>
                                                <tr>
                                                    <th>general contact email (eg sales@ or enquiries@)</th>
                                                    <td><input type="text" class="form-control" name="txt_contact_email" value="<?=$_contact_email?>"/></td>
                                                </tr>
                                                <tr>
                                                    <th>Your company website URL</th>
                                                    <td><input type="text" class="form-control" name="txt_url" value="<?=$_url?>"/></td>
                                                </tr>
                                            </table>                                    
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer clearfix">
                                    <button type="submit" class="btn btn-primary" name="btn_submit_general">Save Changes</button>
                                    </div>
                                    <!-- /.box-footer -->
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="poster_tab">
                            <div class="box box-info">
                                <form role="form" method="post"  enctype="multipart/form-data"> 
                                    <input type="hidden" value="<?=$Id?>" name="hdn_id">
                                    <input type="hidden" value="poster" name="frm_type">
                                    <input type="hidden" name="hdn_event_top" id="hdn_event_top" value="<?=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0?>"/>
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Poster</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="form-group">
                                        <label>Category</label>
                                            <!--
                                            <select class="form-control select2" style="width: 100%;" name="ddl_category">
                                            <option <?=($_category==0)?'selected="selected"':''?> value="0">None</option>                       
                                            <option <?=($_category==1)?'selected="selected"':''?> value="1">CHEST</option>
                                            <option <?=($_category==2)?'selected="selected"':''?> value="2">EDUCATION</option>
                                            <option <?=($_category==3)?'selected="selected"':''?> value="3">GUT</option>
                                            <option <?=($_category==4)?'selected="selected"':''?> value="4">GIT</option>
                                            <option <?=($_category==5)?'selected="selected"':''?> value="5">MAMO/PET CAT</option>
                                            <option <?=($_category==6)?'selected="selected"':''?> value="6">MSK</option>
                                            <option <?=($_category==7)?'selected="selected"':''?> value="7">NEUROLOGY</option>
                                            </select>
                                            -->
                                            <select <?=$_view?> class="form-control select2" style="width: 100%;" name="ddl_category">
                                                <option <?=($_category==0)?'selected="selected"':''?> value="0">None</option>  
                                            <?php
                                                $_top_event_id=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0;
                                                $categories=get_all_categories("eventid=$_top_event_id and status=1");
                                                for($i=0;$i<sizeof($categories);$i++){
                                            ?>
                                            <option <?=($_category==$categories[$i]['catid'])?'selected="selected"':''?> value="<?=$categories[$i]['catid']?>"><?=$categories[$i]['catname']?></option>     
                                            
                                            <?php }?>
                                            </select>
                                        </div><!-- /.form-group -->
                                        <div class="form-group">

                                        <label for="txt_Title">Title</label>

                                        <input <?=$_view?> type="text" class="form-control" name="txt_Title" placeholder="Enter Title" value="<?=$Title?>">

                                        </div>

                                        <div class="form-group">

                                        <label for="txt_Postimage">Image File (Size=350x260px)</label>

                                        <input <?=$_view?> type="file" class="form-control" name="txt_Postimage">
                                        <?php
                                            if($ImageURL!='')
                                            {
                                            ?>
                                            <img src="../<?=$ImageURL?>" height="100">
                                            <?php
                                            }
                                        ?>
                                        </div>  

                                        <div class="form-group">

                                        <label for="txt_PostPDF">PDF File</label>

                                        <input <?=$_view?> type="file" class="form-control" name="txt_PostPDF">
                                        <?php
                                            if($PDFURL!='')
                                            {
                                            ?>
                                            <div>
                                                <button type="button"  class="removePdf" name="btnremove" style="position: absolute;float: right;">X</button>
                                                <img src="../uploads/poster/pdficon.png" width="100">
                                                <input type="hidden" value="<?=$PDFURL?>" name="hdn_poster_pdf" id="hdn_poster_pdf"/>
                                            </div>
                                            <?php
                                            }
                                        ?>
                                        </div>  

                                        <div class="form-group">

                                        <label for="txt_VideoURL">Video URL</label>

                                        <input <?=$_view?> type="text" class="form-control" name="txt_VideoURL" placeholder="Enter VideoURL" value="<?=$VideoURL?>">

                                        </div>

                                            <div class="form-group">

                                        <label for="txt_FAQ">FAQ</label>

                                        <textarea <?=$_view?> class="form-control" name="txt_FAQ" cols="500" rows="10"><?=$FAQ?></textarea>

                                        </div>

                                        <div class="checkbox">

                                        <label>

                                            <input <?=$_view?> type="checkbox" name="chk_status" value="1" <?=($STATUS==1)?'checked':''?>> Active

                                        </label>

                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer clearfix">
                                    <button type="submit" class="btn btn-primary" name="btn_submit_poster">Save Changes</button>
                                    
                                    
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                          <tr>
                                            <th><input type="checkbox" name="chk_all" value="0" onchange="bulkselect(this)"/></th>
                                            <th>Category</th>
                                            <th>Title</th>
                                            <th>Content</th>
                                            <th>Status</th>
                                            <th style="width: 150px!important;text-align: center;">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                          $_top_event_id=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0;
                                           
                                            $userid=$_SESSION['userdata']['userid'];
                                            $roleid=$_SESSION['userdata']['roleid'];
                                            $isapprover=$_SESSION['userdata']['isapprover'];
                                            
                                            if($roleid==1 || $roleid==2)
                                            {
                                                $categories=get_all_posters("p.eventid=$_top_event_id");
                                            }
                                            else
                                            {
                                                $categories=get_all_posters("p.eventid=$_top_event_id and p.createdby=$userid");
                                            }
                                            for($i=0;$i<sizeof($categories);$i++){
                                                
                                                
                                        ?>
                                            <tr>
                                                <!--<td><?=$cats[$categories[$i]['category']]?></td>-->
                                                <td><input type="checkbox" name="chk_all" value="<?=$categories[$i]['Id']?>"/></td>
                                                <td><?=$categories[$i]['catname']?></td>
                                                <td><?=$categories[$i]['Title']?></td>
                                                <td>
                                                     <?php
      
                                                        $posterimg=str_replace("poster/","poster/thumb_",$categories[$i]['ImageURL']);
                                                      ?>
                                                    <!--<img src="../<?=$categories[$i]['ImageURL']?>" width="100" height="100"><br/>-->
                                                    <img src="../<?=$posterimg?>" width="100" height="100"><br/>
                                                    <span><strong>PDF:</strong><?=$categories[$i]['PDFURL']?></span><br/>
                                                    <span><strong>Video:</strong><?=$categories[$i]['VideoURL']?></span><br/>
                                                    <span><strong>FAQ:</strong></span><br/>
                                                    <p>
                                                        <?=$categories[$i]['FAQ']?>
                                                    </p>
                                                </td>
                                                <td><?=$categories[$i]['statusname']?><br/>
                                                    <?php 
                                                      
                                                        if($categories[$i]['isapproved']==0){
                                                            echo "Pending";
                                                        }else if ($categories[$i]['isapproved']==1){
                                                            echo "Approved";
                                                        }else if ($categories[$i]['isapproved']==2){
                                                            echo "Declined";
                                                        }
                                                    ?>
                                                
                                                </td>
                                                <td style="text-align: center;"><?=action_buttons('welcome.php','welcome.php','welcome.php',$categories[$i]['Id'])?>
                                                    <!--
                                                    <hr>
                                                    <input onchange="posterApproveReject(this)" type="radio" value="<?=$categories[$i]['Id']?>" name="ap_rj_<?=$categories[$i]['Id']?>" <?=($categories[$i]['isapproved']==1)?'checked':''?>/> APPROVE 
                                                    <input onchange="posterApproveReject(this)" type="radio" value="<?=($categories[$i]['Id']*-1)?>" name="ap_rj_<?=$categories[$i]['Id']?>" <?=($categories[$i]['isapproved']==0)?'checked':''?>/> DECLINE 
                                                    -->
                                                    <?php if($isapprover==1){?>
                                                    <div class="btn-group-vertical">
                                                      <button type="button" class="btn btn-xs btn-success <?=($categories[$i]['isapproved']==0)?'active':''?>" onclick="posterApproveReject(this)" data-id="<?=$categories[$i]['Id']?>" value="0">Pending</button>
                                                      <button type="button" class="btn btn-xs btn-success <?=($categories[$i]['isapproved']==1)?'active':''?>" onclick="posterApproveReject(this)" data-id="<?=$categories[$i]['Id']?>" value="1">Approve</button>
                                                      <button type="button" class="btn btn-xs btn-success <?=($categories[$i]['isapproved']==2)?'active':''?>" onclick="posterApproveReject(this)" data-id="<?=$categories[$i]['Id']?>" value="2">Decline</button>
                                                    </div>
                                                    <?php }?>
                                                </td>
                                            </tr>                      
                                        <?php
                                            }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                          <tr>
                                              <th><input type="checkbox" name="chk_all" value="0" onchange="bulkselect(this)"/></th>
                                          <th>Category</th>
                                          <th>Title</th>
                                            <th>Content</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                          </tr>
                                          <tr>
                                              <th colspan="6">
                                                  <span id="sp_chk_all" onclick="bulkselect_link(this)"><a href="javascript:void(0)">Check All</a></span>&nbsp;|&nbsp;
                                                  <i>With Selected:</i>
                                                  <select id="ddlActions" onchange="bulk_operations(this)">
                                                    <option value="0">None</option>
                                                    <option value="0" disabled>-----------</option>
                                                    <option value="1">Activate</option>    
                                                    <option value="2">Deactivate</option>    
                                                    <option value="0" disabled>-----------</option>
                                                    <option value="3">Delete</option>    
                                                    
                                                    <?php if($isapprover==1){?>
                                                    <option value="0" disabled>-----------</option>
                                                    <option value="4">Pending</option>
                                                    <option value="5">Approve</option>
                                                    <option value="6">Decline</option>
                                                    <?php }?>
                                                  </select>
                                              </th>
                                          </tr>
                                        </tfoot>
                                      </table>
                                      
                                      
                                    </div>
                                    <!-- /.box-footer -->
                                </form>
                            </div>
                        </div>      
                        <div class="tab-pane" id="qanda_tab">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Q & A</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                          <tr>
                                            <th>Datetime</th>    
                                            <th>Contact Details</th>                        
                                            <th>Poster</th>
                                            <th>Subject</th>                        
                                            <th>Message</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $_top_event_id=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0;
                                             
                                           
                                            $userid=$_SESSION['userdata']['userid'];
                                            $roleid=$_SESSION['userdata']['roleid'];
                                            $isapprover=$_SESSION['userdata']['isapprover'];
                                            
                                            if($roleid==1 || $roleid==2)
                                            {
                                                $roles=get_all_helpdesks2("eventid=$_top_event_id");
                                            }
                                            else
                                            {
                                                $roles=get_all_helpdesks2("p.eventid=$_top_event_id and p.createdby=$userid");
                                            }
                                            
                                            
                                            
                                            for($i=0;$i<sizeof($roles);$i++){
                                        ?>
                                            <tr>
                                                <td><?=$roles[$i]['datetime']?></td>
                                                <td>Name:<?=$roles[$i]['cname']?><br/>Email:<?=$roles[$i]['email']?></td>
                                                <td><?=$roles[$i]['title']?></td>
                                                <td><?=$roles[$i]['subject']?></td>
                                                <td><?=$roles[$i]['message']?></td>
                                            </tr>                      
                                        <?php
                                            }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                          <tr>
                                            <th>Datetime</th>    
                                            <th>Contact Details</th>                        
                                            <th>Poster</th>
                                            <th>Subject</th>                        
                                            <th>Message</th>
                                          </tr>
                                        </tfoot>
                                      </table>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer clearfix">
                                </div>
                                <!-- /.box-footer -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
        Footer
        </div>
    </div><!-- /.box -->
    </section>
    <!-- /.content -->
    <?php include('inc/footer.php');?>