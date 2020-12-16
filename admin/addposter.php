<?php include('inc/header.php'); ?>



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

    if(isset($_POST['btn_submit']))
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

        <h3 class="box-title"><?=get_page_name("formurl='".basename($_SERVER['PHP_SELF'])."'")[0]['formname'];?></h3>

        <div class="box-tools pull-right">

        <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>

        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->

        </div>

    </div>

    <!-- form start -->

    <form role="form" method="post"  enctype="multipart/form-data"> 
    <input type="hidden" value="<?=$Id?>" name="hdn_id">
    <input type="hidden" name="hdn_event_top" id="hdn_event_top" value="<?=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0?>"/>
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

                  </div><!-- /.box-body -->



                  <div class="box-footer">

                    <button type="submit" class="btn btn-primary" name="btn_submit">Submit</button>

                  </div>

                </form>

    </div><!-- /.box -->



    </section><!-- /.content -->

<?php include('inc/footer.php');?>