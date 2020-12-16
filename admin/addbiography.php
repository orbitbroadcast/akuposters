<?php include('inc/header.php'); 

$_id='';
$_title='';
$_position='';
$_description='';
$_image='';
$_status='';
$_facebook='';
$_twitter='';
$_google='';
$_linkedin='';
$_view='';

if(isset($_GET['type']) && $_GET['type']=='edit')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $events=select('select * from tbl_biographies where id='.$id);
    if(sizeof($events)>0)
    {        
        $_id=$id;
        $_title=$events[0]['title'];
        $_position=$events[0]['position'];
        $_description=$events[0]['description'];
        $_image=$events[0]['image'];
        $_status=$events[0]['status'];
        $_facebook=$events[0]['facebook'];
        $_twitter=$events[0]['twitter'];
        $_google=$events[0]['google'];
        $_linkedin=$events[0]['linkedin'];
        
    }
  }
  elseif(isset($_GET['type']) && $_GET['type']=='del')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $_dqry="delete from  tbl_biographies where id=".$id;
    if ($conn->query($_dqry) === TRUE)
    {
      ?><script>location.href='biographies.php';</script><?php
    }
    
  }
  elseif(isset($_GET['id']))
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $events=select('select * from tbl_biographies where id='.$id);
    if(sizeof($events)>0)
    {
      $_id=$id;
      $_title=$events[0]['title'];
      $_position=$events[0]['position'];
      $_description=$events[0]['description'];
      $_image=$events[0]['image'];
      $_status=$events[0]['status'];
      $_facebook=$events[0]['facebook'];
      $_twitter=$events[0]['twitter'];
      $_google=$events[0]['google'];
      $_linkedin=$events[0]['linkedin'];
        $_view='disabled';
    }
  }

?>

<?php

    $imagedit=1;
    if(isset($_POST['btn_submit'])){
        extract($_POST);
        $chk_status=isset($chk_status)?$chk_status:0;     
        $txt_title_name=mysqli_escape_string($conn,$txt_title_name);
        $txt_position_name=mysqli_escape_string($conn,$txt_position_name);
        $txt_description=mysqli_escape_string($conn,$txt_description);
        $txt_twitter=mysqli_escape_string($conn,$txt_twitter);
        $txt_facebook=mysqli_escape_string($conn,$txt_facebook);
        $txt_google  =mysqli_escape_string($conn,$txt_google);
        $txt_linkedin=mysqli_escape_string($conn,$txt_linkedin);

        
        $fileinfo = @getimagesize($_FILES["txt_catimage"]["tmp_name"]);
        
        $width = $fileinfo[0];  
        $height = $fileinfo[1];
        
        $target_dir = "../uploads/bio/";
        $target_file = $target_dir . basename($_FILES["txt_catimage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["txt_catimage"]["tmp_name"]);
        if($check !== false) {         
          $uploadOk = 1;
          if(true){//if($width==352 && $height==458){
            if (move_uploaded_file($_FILES["txt_catimage"]["tmp_name"], $target_file)) {
              echo "The file ". basename( $_FILES["txt_catimage"]["name"]). " has been uploaded.<br/>";
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
        if($uploadOk==1){

          if($_GET['type']=='edit')
          {
            if($imagedit==0){
              $qry="update tbl_biographies set title='$txt_title_name',
              position='$txt_position_name',
              description='$txt_description',
              facebook='$txt_facebook',
              twitter='$txt_twitter',
              google='$txt_google',
              linkedin='$txt_linkedin',
              status=$chk_status
                                          where id=$hdn_id";

        
            }
            else
            {
            $qry="update tbl_biographies set title='$txt_title_name',
            position='$txt_position_name',
            description='$txt_description',
            image='$_target_file',
            facebook='$txt_facebook',
              twitter='$txt_twitter',
              google='$txt_google',
              linkedin='$txt_linkedin',
            status=$chk_status
                                        where id=$hdn_id";
            }
             $qry;
                                        if ($conn->query($qry) === TRUE) {
                                          echo "Record updated successfully";
                                        } else {
                                          echo "Error: " . $qry . "<br>" . $conn->error;
                                        } 
          }
          else
          {
          $qry="insert into tbl_biographies (title,position,description,image,status,eventid,facebook,twitter,google,linkedin) values('$txt_title_name','$txt_position_name','$txt_description','$_target_file',$chk_status,$hdn_event_top,'$txt_facebook','$txt_twitter','$txt_google','$txt_linkedin')";
          
          
          if ($conn->query($qry) === TRUE) {
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
        <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
        </div>
    </div>
    <!-- form start -->
    <form role="form" method="post" enctype="multipart/form-data">
    <input type="hidden" value="<?=$_id?>" name="hdn_id">
    <input type="hidden" name="hdn_event_top" id="hdn_event_top" value="<?=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0?>"/>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="txt_title_name">Title or name</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_title_name" placeholder="Enter tile" value="<?=$_title?>">
                    </div>   
                    <div class="form-group">
                      <label for="txt_position_name">Sub title / position</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_position_name" placeholder="Enter Sub title / position" value="<?=$_position?>">
                    </div>     
                    <div class="form-group">
                      <label for="txt_description">Description</label>
                      <textarea <?=$_view?> class="form-control" name="txt_description" cols="500" rows="10"><?=$_description?></textarea>
                    </div>                 
                    <div class="form-group">
                      <label for="txt_catimage">Image (Size= 350x300px)</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_catimage">
                      <?php
                        if($_image!='')
                        {
                          ?>
                          <img src="../<?=$_image?>" width="150" height="129">
                          <?php
                        }
                      ?>
                    </div>        
                    <div class="form-group">
                      <label for="txt_position_name">Twitter</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_twitter" placeholder="Enter twitter profile" value="<?=$_twitter?>">
                    </div>  
                    <div class="form-group">
                      <label for="txt_position_name">Facebook</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_facebook" placeholder="Enter facebook profile" value="<?=$_facebook?>">
                    </div>  
                    <div class="form-group">
                      <label for="txt_position_name">Google+</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_google" placeholder="Enter google+ profile" value="<?=$_google?>">
                    </div>  
                    <div class="form-group">
                      <label for="txt_position_name">LinkedIn</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_linkedin" placeholder="Enter linkedin" value="<?=$_linkedin?>">
                    </div>              
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_status" value="1" <?=($_status==1)?'checked':''?>> Active
                      </label>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button <?=$_view?> type="submit" class="btn btn-primary" name="btn_submit">Submit</button>
                  </div>
                </form>
    </div><!-- /.box -->

    </section><!-- /.content -->
<?php include('inc/footer.php');?>